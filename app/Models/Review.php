<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_item_id',
        'product_variant_id',   // ← BẮT BUỘC PHẢI CÓ
        'rating',
        'title',
        'content',
        'status','reply', 'replied_at', 'replied_by'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean','replied_at' => 'datetime',
    ];

    // Quan hệ
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
  

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function repliedBy()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }
}
