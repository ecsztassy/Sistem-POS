<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Transaction;
use App\Models\TransactionDetail;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $today = Transaction::whereDate('created_at', today());

        return view('dashboard', [
            'revenue' => (clone $today)->sum('total_price'), 'count' => $today->count(),
            'profit' => TransactionDetail::whereHas('transaction', fn ($q) => $q->whereDate('created_at', today()))->selectRaw(TransactionDetail::PROFIT_SQL.' as profit')->value('profit'),
            'itemCount' => Item::count(), 'lowStock' => Item::where('stock', '<=', 5)->orderBy('stock')->limit(8)->get(),
            'recent' => Transaction::with('user')->latest()->limit(6)->get(),
            'week' => collect(range(6, 0))->map(fn ($offset) => ['day' => today()->subDays($offset)->format('d M'), 'total' => (int) Transaction::whereDate('created_at', today()->subDays($offset))->sum('total_price')]),
        ]);
    }
}
