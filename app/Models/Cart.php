<?php

namespace App\Models;

use App\Models\User;
use App\Models\CartItem;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    /** @use HasFactory<\Database\Factories\CartFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'total_amount', 'note'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function items()
    {
        return $this->hasMany(CartItem::class, 'cart_id');
    }

    // Helpers / Scopes
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForGuest($query, $token)
    {
        return $query->where('guest_token', $token);
    }

    public function getTotalQuantityAttribute()
    {
        return $this->items()->sum('quantity');
    }

    public function getItemCountAttribute()
    {
        return $this->items()->count();
    }
}

