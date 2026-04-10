<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'payment_method',
        'status',
        'transaction_id',
        'payment_data',
        'paid_at',
        'note',
    ];

    protected $casts = [
        'amount'         => 'decimal:2',
        'status'         => 'string',
        'payment_method' => 'string',
        'paid_at'        => 'datetime',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Scopes
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeCod($query)
    {
        return $query->where('payment_method', 'cod');
    }

    // Accessor
    public function getIsPaidAttribute()
    {
        return $this->status === 'paid';
    }
}