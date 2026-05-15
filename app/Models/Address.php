<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'province',
        'district',
        'ward',
        'address',
        'is_default',
        'type',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope để lấy địa chỉ mặc định
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    // Accessor để lấy địa chỉ đầy đủ
    public function getFullAddressAttribute()
    {
        return $this->address . ', ' . $this->ward . ', ' . $this->district . ', ' . $this->province;
    }
}
