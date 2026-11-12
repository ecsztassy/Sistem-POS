<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<style>body{font:11px DejaVu Sans,sans-serif;color:#18352b}h1{font-size:22px}table{width:100%;border-collapse:collapse;margin-top:25px}th,td{text-align:left;padding:10px 6px;border-bottom:1px solid #ddd}th{background:#edf4f0}small{color:#777}</style>
</head>
<body>
<h1>{{ $store->name??'Ritel POS' }}</h1>
<p>Laporan penjualan · {{ $start }} s.d. {{ $end }}</p>
<p>Pendapatan: @currency($revenue) &nbsp; | &nbsp; Laba: @currency($profit) &nbsp; | &nbsp; Transaksi: {{ $count }}</p>
<table>
<thead>
<tr>
<th>Invoice</th>
<th>Tanggal</th>
<th>Kasir</th>
<th>Total</th>
<th>Bayar</th>
<th>Kembalian</th>
</tr>
</thead>
<tbody>@foreach($transactions as $transaction)<tr>
<td>{{ $transaction->invoice_code }}</td>
<td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
<td>{{ $transaction->user->name }}</td>
<td>@currency($transaction->total_price)</td>
<td>@currency($transaction->pay_amount)</td>
<td>@currency($transaction->change_amount)</td>
</tr>@endforeach</tbody>
</table>
<p>
<small>Dicetak {{ now()->format('d/m/Y H:i') }} WIB</small>
</p>
</body>
</html>
