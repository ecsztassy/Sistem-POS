<?php

namespace App\Services;

use App\Models\Item;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CheckoutService
{
    public function checkout(User $user, array $data): Transaction
    {
        return DB::transaction(function () use ($user, $data) {
            // Serialize submissions by this cashier, including retries of a checkout token.
            User::whereKey($user->id)->lockForUpdate()->firstOrFail();
            $existing = Transaction::where('checkout_token', $data['checkout_token'])->first();
            if ($existing) {
                abort_unless($existing->user_id === $user->id, 403);

                return $existing;
            }
            $items = Item::whereIn('id', array_column($data['items'], 'item_id'))->whereHas('category', fn ($q) => $q->whereNull('deleted_at'))->orderBy('id')->lockForUpdate()->get()->keyBy('id');
            $total = 0;
            $details = [];
            foreach ($data['items'] as $line) {
                $item = $items->get($line['item_id']);
                if (! $item || $item->stock < $line['qty']) {
                    throw ValidationException::withMessages(['items' => 'Stok barang tidak mencukupi atau barang tidak tersedia.']);
                }
                $subtotal = $item->sell_price * $line['qty'];
                $total += $subtotal;
                $details[] = ['item_id' => $item->id, 'item_name' => $item->name, 'item_code' => $item->item_code, 'qty' => $line['qty'], 'price' => $item->sell_price, 'buy_price' => $item->buy_price, 'subtotal' => $subtotal];
            }
            if ($data['pay_amount'] < $total) {
                throw ValidationException::withMessages(['pay_amount' => 'Uang pembayaran kurang dari total belanja.']);
            }
            $transaction = Transaction::create(['invoice_code' => 'TRX-'.now()->format('Ymd').'-'.strtoupper((string) Str::ulid()), 'user_id' => $user->id, 'total_price' => $total, 'pay_amount' => $data['pay_amount'], 'change_amount' => $data['pay_amount'] - $total, 'notes' => $data['notes'] ?? null, 'checkout_token' => $data['checkout_token']]);
            $transaction->details()->createMany($details);
            foreach ($details as $line) {
                $items[$line['item_id']]->decrement('stock', $line['qty']);
            }

            return $transaction;
        }, 3);
    }
}
