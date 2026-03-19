<?php


namespace App\Models\Admin;
// use Database\Factories\OrderFactory;
use App\Models\Admin\Payment;
use App\Models\Admin\OrderItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'order_code',
        'subtotal',
        'discount_amount',
        'shipping_fee',
        'total_amount',
        'status',
        'payment_method',
        'payment_status',
        'receiver_name',
        'receiver_phone',
        'receiver_address',
        'receiver_ward',
        'receiver_district',
        'receiver_province',
        'note',
        'admin_note',
        'voucher_id',
    ];

    protected $casts = [
        'subtotal'       => 'decimal:2',
        'discount_amount'=> 'decimal:2',
        'shipping_fee'   => 'decimal:2',
        'total_amount'   => 'decimal:2',
        'status'         => 'string',
        'payment_method' => 'string',
        'payment_status' => 'string',
    ];
//     protected static function newFactory()
// {
//     return OrderFactory::new();
// }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // public function voucher()
    // {
    //     return $this->belongsTo(Voucher::class);
    // }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeCod($query)
    {
        return $query->where('payment_method', 'cod');
    }

    // Accessors
    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->receiver_address,
            $this->receiver_ward,
            $this->receiver_district,
            $this->receiver_province,
        ]);

        return implode(', ', $parts);
    }

    public function getIsCodAttribute()
    {
        return $this->payment_method === 'cod';
    }
}