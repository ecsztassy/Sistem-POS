<?php

// Optional integration check against the configured local MySQL database.
// Every fixture and checkout write is rolled back in the finally block.
require __DIR__.'/../../vendor/autoload.php';
$app = require __DIR__.'/../../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

use App\Models\Category;
use App\Models\Item;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use App\Services\CheckoutService;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

if (DB::getDriverName() !== 'mysql' || ! app()->environment('local')) {
    throw new RuntimeException('This check requires local MySQL.');
}

DB::beginTransaction();
try {
    $suffix = (string) Str::uuid();
    $user = User::create(['name' => 'Integration check', 'username' => $suffix, 'password' => Str::random(32), 'role' => 'kasir']);
    $category = Category::create(['name' => 'Integration check']);
    $item = Item::create(['category_id' => $category->id, 'item_code' => $suffix, 'name' => 'Integration check', 'username' => $suffix, 'buy_price' => 6000, 'sell_price' => 5000, 'stock' => 2, 'unit' => 'pcs']);
    $data = ['checkout_token' => (string) Str::uuid(), 'pay_amount' => 7000, 'items' => [['item_id' => $item->id, 'qty' => 1]]];
    $service = app(CheckoutService::class);
    $transaction = $service->checkout($user, $data);
    $duplicate = $service->checkout($user, $data);
    $profit = TransactionDetail::where('transaction_id', $transaction->id)->selectRaw(TransactionDetail::PROFIT_SQL.' as profit')->value('profit');
    if ($transaction->total_price !== 5000 || $transaction->change_amount !== 2000 || $item->fresh()->stock !== 1 || $duplicate->id !== $transaction->id || (int) $profit !== -1000) {
        throw new RuntimeException('MySQL checkout regression detected.');
    }
    $engine = DB::selectOne('SELECT ENGINE AS engine FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ?', ['items']);
    if (strtolower($engine->engine ?? '') !== 'innodb') {
        throw new RuntimeException('Inventory tables require InnoDB.');
    }
    echo "MySQL/InnoDB checkout, stock, idempotency, and negative profit: PASS\n";
} finally {
    DB::rollBack();
}

if (Transaction::where('checkout_token', $data['checkout_token'])->exists()) {
    throw new RuntimeException('Integration fixtures were not rolled back.');
}
echo "Integration fixtures rolled back: PASS\n";
