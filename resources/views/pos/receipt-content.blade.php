<div style="text-align:center">
<h1>{{ $store->name??'Ritel POS' }}</h1>
<div>{{ $store->address??'' }}</div>
<div>{{ $store->phone??'' }}</div>
</div>
<hr>
<div>{{ $transaction->invoice_code }}</div>
<div>{{ $transaction->created_at->format('d/m/Y H:i:s') }} WIB</div>
<div>Kasir: {{ $transaction->user->name }}</div>
<hr>
<table>@foreach($transaction->details as $detail)<tr>
<td colspan="2">{{ $detail->item_name }}</td>
</tr>
<tr>
<td>{{ $detail->qty }} × {{ number_format($detail->price,0,',','.') }}</td>
<td style="text-align:right">{{ number_format($detail->subtotal,0,',','.') }}</td>
</tr>@endforeach</table>
<hr>
<table>
<tr>
<td>
<strong>TOTAL</strong>
</td>
<td style="text-align:right">
<strong>@currency($transaction->total_price)</strong>
</td>
</tr>
<tr>
<td>Tunai</td>
<td style="text-align:right">@currency($transaction->pay_amount)</td>
</tr>
<tr>
<td>Kembalian</td>
<td style="text-align:right">@currency($transaction->change_amount)</td>
</tr>
</table>@if($transaction->notes)<hr>
<div>Catatan: {{ $transaction->notes }}</div>@endif<hr>
<p style="text-align:center">{{ $store->footer_note??'Terima kasih telah berbelanja!' }}</p>
