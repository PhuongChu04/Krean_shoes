<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_variants';

    protected $fillable = [
        'product_id',
        'size_id',
        'color_id',
        'price',
        'stock',
        'sku',
    ];

    // Quan hệ
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_variant_id');
    }

    public function getAttributeNameAttribute()
    {
        $color = $this->color?->name;
        $size = $this->size?->name;

        $parts = array_filter([$color, $size], fn($v) => !is_null($v) && $v !== '');

        if (!empty($parts)) {
            return implode(' / ', $parts);
        }

        // Fallback/Legacy
        return null;
    }
}