<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'image',
        'id_parent',
    ];

    // Quan hệ tự tham chiếu (parent - children)
public function children()
{
    return $this->hasMany(Category::class, 'id_parent', 'id');
}

public function parent()
{
    return $this->belongsTo(Category::class, 'id_parent', 'id');
}

    // 1 Category có nhiều Product
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}