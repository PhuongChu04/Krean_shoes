<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    // 1 Brand có nhiều Product
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}