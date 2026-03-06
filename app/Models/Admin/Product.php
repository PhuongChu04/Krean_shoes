<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'thumbnail',
        'category_id',
        'brand_id',
        'is_featured',
        'status',
    ];

    // Quan hệ
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    // Không cần quan hệ size/color trực tiếp trên Product (chúng nằm trên Variant)
    // Xóa quan hệ sai: product(), size(), color(), images() (images thuộc Variant)
}