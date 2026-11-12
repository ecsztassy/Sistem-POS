<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessTransactionRequest;
use App\Http\Requests\TableRequest;
use App\Models\Item;
use App\Models\StoreSetting;
use App\Models\Transaction;
use App\Services\CheckoutService;
use Barryvdh\DomPDF\Facade\Pdf;

class PosController extends Controller
{
    public function index()
    {
        return view('pos.index');
    }

    public function search(TableRequest $request)
    {
        $data = $request->validated();
        $search = $data['q'] ?? '';
        $query = Item::where('stock', '>', 0)->whereHas('category', fn ($q) => $q->whereNull('deleted_at'));
        if (! empty($data['ids'])) {
            $query->whereIn('id', $data['ids']);
        } else {
            $query->where(fn ($q) => $q->where('name', 'like', "%{$search}%")->orWhere('item_code', 'like', "%{$search}%"));
        }

        return response()->json($query->orderBy('name')->limit(! empty($data['ids']) ? 100 : 24)->get(['id', 'item_code', 'name', 'sell_price', 'stock', 'unit']));
    }

    public function checkout(ProcessTransactionRequest $request, CheckoutService $checkout)
    {
        $transaction = $checkout->checkout($request->user(), $request->validated());

        return to_route('pos.receipt', $transaction)->with('success', 'Transaksi berhasil disimpan.');
    }

    private function receiptData(Transaction $transaction): array
    {
        abort_unless(auth()->user()->role === 'admin' || $transaction->user_id === auth()->id(), 403);

        return ['transaction' => $transaction->load('details', 'user'), 'store' => StoreSetting::first()];
    }

    public function receipt(Transaction $transaction)
    {
        return view('pos.receipt', $this->receiptData($transaction));
    }

    public function pdf(Transaction $transaction)
    {
        return Pdf::loadView('pos.receipt-pdf', $this->receiptData($transaction))->setPaper([0, 0, 226.77, 900])->download($transaction->invoice_code.'.pdf');
    }

    public function daily()
    {
        $query = Transaction::with('user')->whereDate('created_at', today());
        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }

        return view('pos.daily', ['total' => (clone $query)->sum('total_price'), 'transactions' => $query->latest()->paginate(20)]);
    }
}
