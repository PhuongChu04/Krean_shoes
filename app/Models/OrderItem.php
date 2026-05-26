<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'product_variant_id',

        // === SNAPSHOT - DỮ LIỆU TĨNH LÚC MUA (RẤT QUAN TRỌNG) ===
        'product_name',
        'variant_name',
        'size_name',
        'color_name',
        'product_image',
        'product_attribute',   // JSON: size_id, color_id, ...
        
        'quantity',
        'price',
        'discount_amount',
        'subtotal',
    ];

    protected $casts = [
        'quantity'          => 'integer',
        'price'             => 'decimal:2',
        'discount_amount'   => 'decimal:2',
        'subtotal'          => 'decimal:2',
        'product_attribute' => 'array',
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

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    // ==================== ACCESSORS ====================
public function getProductNameAttribute()
{
    return $this->attributes['product_name'] ?? 
           ($this->variant?->product?->name ?? 'Sản phẩm đã bị xóa');
}

public function getFullVariantNameAttribute()
{
    return $this->variant_name ?? 
           trim(($this->color_name ?? '') . ' - ' . ($this->size_name ?? ''));
}

// public function getProductImageAttribute()
// {
//     return $this->attributes['product_image'] ?? null;
// }

public function getImageUrlAttribute(): string
{
    $path = $this->getRawOriginal('product_image');

    if (!empty($path)) {
        // Kiểm tra file có thực sự tồn tại không
        $cleanPath = preg_replace('#^public/#', '', $path);
        
        if (Storage::disk('public')->exists($cleanPath)) {
            return Storage::url($cleanPath);
        }
        // File không tồn tại → fallback xuống dưới
    }

    // Fallback 1: ảnh từ variant (load từ DB)
    if ($this->product_variant_id) {
        $variantImage = \App\Models\ProductImage::where('product_variant_id', $this->product_variant_id)
            ->first();
        if ($variantImage) {
            return Storage::url($variantImage->image);
        }
    }

    // Fallback 2: thumbnail sản phẩm
    if ($this->relationLoaded('variant') && $this->variant?->product?->thumbnail) {
        return Storage::url($this->variant->product->thumbnail);
    }

    return asset('images/default-product.jpg');
}
}