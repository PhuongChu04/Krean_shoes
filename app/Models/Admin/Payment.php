<?php

namespace App\Models\Admin;

use App\Models\Admin\Order;
use App\Models\Admin\ProductVariant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_variant_id',
        'quantity',
        'price',
        'subtotal',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price'    => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relationships
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    // Accessor (dự phòng)
    public function getNameAttribute()
    {
        return $this->variant?->product?->name ?? 'Sản phẩm đã xóa';
    }
}