<?php

namespace App\Models\Admin;

use App\Models\Admin\ProductVariant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'colors'; // không bắt buộc vì tên model đã plural

    protected $fillable = [
        'name',
        'code',
    ];

    /**
     * Một màu có thể thuộc về nhiều biến thể sản phẩm
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Scope: chỉ lấy màu chưa xóa mềm
     */
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * Accessor: hiển thị màu đẹp hơn (ví dụ trong select hoặc preview)
     */
    public function getDisplayAttribute()
    {
        return $this->name . ($this->code ? ' (' . $this->code . ')' : '');
    }
}