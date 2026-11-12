<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Http\Requests\TableRequest;
use App\Models\StoreSetting;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    private function data(TableRequest $request): array
    {
        $filters = $request->validated();
        $start = $filters['start_date'] ?? today()->startOfMonth()->format('Y-m-d');
        $end = $filters['end_date'] ?? today()->format('Y-m-d');
        if ($end < $start) {
            throw ValidationException::withMessages(['end_date' => 'Tanggal akhir harus setelah tanggal awal.']);
        }
        $from = Carbon::parse($start)->startOfDay();
        $until = Carbon::parse($end)->addDay()->startOfDay();
        $query = Transaction::with('user')->where('created_at', '>=', $from)->where('created_at', '<', $until);

        return ['start' => $start, 'end' => $end, 'query' => $query, 'revenue' => (clone $query)->sum('total_price'), 'count' => (clone $query)->count(), 'profit' => TransactionDetail::whereHas('transaction', fn ($q) => $q->where('created_at', '>=', $from)->where('created_at', '<', $until))->selectRaw(TransactionDetail::PROFIT_SQL.' as profit')->value('profit')];
    }

    public function index(TableRequest $request)
    {
        $data = $this->data($request);

        return view('reports.index', $data + ['transactions' => $data['query']->latest()->get()]);
    }

    public function excel(TableRequest $request)
    {
        $data = $this->data($request);

        return Excel::download(new SalesExport($data['query']), 'penjualan-'.$data['start'].'-'.$data['end'].'.xlsx');
    }

    public function pdf(TableRequest $request)
    {
        $data = $this->data($request);

        return Pdf::loadView('reports.pdf', $data + ['transactions' => $data['query']->orderBy('created_at')->get(), 'store' => StoreSetting::first()])->setPaper('a4', 'landscape')->download('laporan-penjualan.pdf');
    }
}
