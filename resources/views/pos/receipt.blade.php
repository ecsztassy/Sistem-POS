<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
@include('partials.favicon')
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Struk {{ $transaction->invoice_code }}</title>@vite(['resources/css/app.css','resources/js/app.js'])<style id="paper-size">
</style>
</head>
<body>
<div class="receipt-actions flex-wrap">
<a class="btn btn-light border" href="{{ route('pos.index') }}">Transaksi baru</a>
<select class="form-select w-auto" aria-label="Ukuran kertas" onchange="document.querySelector('.receipt').classList.toggle('narrow',this.value==='58');document.getElementById('paper-size').textContent='@media print { @page { size: '+this.value+'mm auto; } }'">
<option value="80">80 mm</option>
<option value="58">58 mm</option>
</select>
<button class="btn btn-primary" onclick="window.print()">
<i class="fa-solid fa-print me-2">
</i> Cetak struk</button>
<a class="btn btn-light border" href="{{ route('pos.receipt.pdf',$transaction) }}">Unduh PDF</a>
</div>
<main class="receipt">@include('pos.receipt-content')</main>
</body>
</html>
