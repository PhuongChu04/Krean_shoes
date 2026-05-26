<?php


namespace App\Models;
// use Database\Factories\OrderFactory;
use App\Models\Payment;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'user_name',
        'order_code',
        'subtotal',
        'discount_amount',
        'discount_type',
        'shipping_fee',
        'total_amount',
        'status',
        'delivery_at',
        'payment_method',
        'payment_status',
        'receiver_name',
        'receiver_phone',
        'receiver_address',
        'receiver_ward',
        'receiver_district',
        'receiver_province',
        'note',
        'cancel_reason',
        'admin_note',
        'voucher_id',
    ];

    protected $casts = [
        'subtotal'       => 'decimal:2',
        'discount_amount'=> 'decimal:2',
        'shipping_fee'   => 'decimal:2',
        'total_amount'   => 'decimal:2',
        'delivery_at'    => 'datetime',
        'status'         => 'string',
        'payment_method' => 'string',
        'payment_status' => 'string',
        'discount_type'  => 'string',
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

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

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

    public function getPaymentMethodLabelAttribute()
    {
        return match ($this->payment_method) {
            'cod' => 'Thanh toán khi nhận hàng (COD)',
            'vnpay' => 'Thanh toán online qua VNPay',
            'bank' => 'Chuyển khoản ngân hàng',
            'momo' => 'Ví MoMo',
            'card' => 'Thẻ ngân hàng',
            default => strtoupper((string) $this->payment_method),
        };
    }

    public function getPaymentStatusLabelAttribute()
    {
        return match ($this->payment_status) {
            'pending' => 'Chờ thanh toán',
            'paid' => 'Đã thanh toán',
            'failed' => 'Thanh toán thất bại',
            'refunded' => 'Đã hoàn tiền',
            default => ucfirst((string) $this->payment_status),
        };
    }

    /**
     * Kiểm tra có thể thanh toán lại không
     * Điều kiện:
     * - payment_status = pending (chưa thanh toán)
     * - payment_method = vnpay
     * - status = pending (đơn hàng đang chờ xử lý)
     * - Chỉ cho thanh toán lại 1 lần duy nhất
     * 
     * Logic: Chỉ cho retry nếu:
     * 1. Chưa có payment nào paid (thành công)
     * 2. Tối đa 1 payment record (payment ban đầu, chưa retry)
     */
    public function canRetryPayment()
    {
        // Kiểm tra điều kiện cơ bản
        if ($this->payment_status !== 'pending' || $this->payment_method !== 'vnpay' || $this->status !== 'pending') {
            return false;
        }

        // Đếm số lượng payment records
        $paymentCount = $this->payments()->count();
        
        // Kiểm tra có payment nào paid không
        $hasPaidPayment = $this->payments()->where('status', 'paid')->exists();

        // Cho phép retry nếu:
        // - Chưa có payment nào thành công (paid)
        // - Số payment attempts <= 1 (chỉ có payment ban đầu, chưa retry)
        return !$hasPaidPayment && $paymentCount <= 1;
    }
}