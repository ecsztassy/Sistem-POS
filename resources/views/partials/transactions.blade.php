<div class="table-responsive">
<table class="table mb-0 {{ ($dataTable??false)?'datatable':'' }}">
<thead>
<tr>
<th>Invoice</th>
<th>Waktu</th>
<th>Kasir</th>
<th>Total</th>
<th>Status</th>
<th>
</th>
</tr>
</thead>
<tbody>@foreach($transactions as $transaction)<tr>
<td class="fw-semibold">{{ $transaction->invoice_code }}</td>
<td class="subtle">{{ $transaction->created_at->format('d M Y, H:i') }}</td>
<td>{{ $transaction->user->name }}</td>
<td class="fw-semibold">@currency($transaction->total_price)</td>
<td>
<span class="badge badge-soft">Selesai</span>
</td>
<td>
<a href="{{ route('pos.receipt',$transaction) }}" class="btn btn-sm btn-light" aria-label="Lihat struk">
<i class="fa-solid fa-arrow-up-right-from-square">
</i>
</a>
</td>
</tr>@endforeach</tbody>
</table>@if(count($transactions)===0)<div class="empty-state">Belum ada transaksi dalam periode ini.</div>@endif</div>
