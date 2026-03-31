<?php

namespace App\Models\Admin;

use App\Models\Admin\Order;
// use Database\Factories\OrderItemFactory;
use App\Models\Admin\ProductVariant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'product_name',
        'product_variant_sku',
        'product_image',
        'product_attribute',
        'product_variant_id',
        'quantity',
        'price',
        'discount_amount',
        'subtotal',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price'    => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];
//     protected static function newFactory()
// {
//     return OrderItemFactory::new();
// }

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