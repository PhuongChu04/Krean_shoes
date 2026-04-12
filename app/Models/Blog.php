<?php

namespace App\Models;

use App\Models\BlogCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [

        'title',
        'slug',
        'summary',
        'content',
        'thumbnail',
        'status',
        'author_id',
        'blog_category_id',
    ];

    /**
     * Danh mục của bài viết
     */
    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }
    /**
     * Tác giả bài viết
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
