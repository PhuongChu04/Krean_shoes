<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'description',
        'type',
        'quantity',
        'discount_amount',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'user_vouchers')
            ->withPivot('is_used', 'used_at')
            ->withTimestamps();
    }

    // Scope để lấy voucher còn hiệu lực
    public function scopeActive($query)
    {
        return $query->where('status', 'active')
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('quantity', '>', 0);
    }

    // Scope để lấy voucher có thể áp dụng cho user
    // Với business rule hiện tại, chỉ cần kiểm tra voucher còn hoạt động,
    // quantity > 0 và thời gian còn hiệu lực.
    public function scopeAvailableForUser($query, $userId)
    {
        return $query->active();
    }
}
