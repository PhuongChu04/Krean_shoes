<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'img',
        'link',
        'priority',
        'type',           // ✅ thêm dòng này
        'category_id'     // ✅ và dòng này
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
