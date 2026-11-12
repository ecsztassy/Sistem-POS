<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionDetail extends Model
{
    // Signed casts allow a loss even when prices are unsigned columns in MySQL.
    public const PROFIT_SQL = 'COALESCE(SUM((CAST(price AS SIGNED) - CAST(buy_price AS SIGNED)) * qty), 0)';

    protected $fillable = ['item_id', 'item_name', 'item_code', 'qty', 'price', 'buy_price', 'subtotal'];

    protected $casts = ['qty' => 'integer', 'price' => 'integer', 'buy_price' => 'integer', 'subtotal' => 'integer'];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class)->withTrashed();
    }
}
