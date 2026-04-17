<?php

namespace App\Models;

use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends Model
{
     protected $casts = [
        'quantity' => 'integer',
        'price'    => 'decimal:2',
    ];
    /** @use HasFactory<\Database\Factories\CartItemFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['cart_id', 'product_variant_id', 'quantity', 'unit_price', 'total_price', 'note'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
    public function productVariant()
    {
        // Giả sử khóa ngoại trong bảng cart_items là 'product_variant_id'
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function getAttributeNameAttribute()
    {
        return $this->productVariant?->attribute_name;
    }

    // Accessor
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->price;
    }

    protected static function booted()
    {
        static::saved(function ($cartItem) {
            $cartItem->updateCartTotalAmount();
        });

        // Use deleted instead of forceDeleted since CartItem does not use SoftDeletes
        static::deleted(function ($cartItem) {
        static::forceDeleted(function ($cartItem) {
            $cartItem->updateCartTotalAmount();
        });
         });
    }

    public function updateCartTotalAmount()
    {
        $cart = $this->cart;
        if (!$cart) {
            return;
        }

        // Tính tổng total_price của tất cả cart_items thuộc cart này
        $totalAmount = $cart->items()->sum('total_price');

        // Nếu không có item nào thì totalAmount sẽ là null hoặc 0, đảm bảo là số 0
        $totalAmount = $totalAmount;

        // Cập nhật lại tổng giá trị
        $cart->total_amount = $totalAmount;
        $cart->save();
    }
}

