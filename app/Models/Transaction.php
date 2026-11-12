<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    protected $fillable = ['invoice_code', 'user_id', 'total_price', 'pay_amount', 'change_amount', 'notes', 'checkout_token'];

    protected $casts = ['user_id' => 'integer', 'total_price' => 'integer', 'pay_amount' => 'integer', 'change_amount' => 'integer'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
