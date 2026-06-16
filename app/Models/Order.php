<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'razorpay_order_id', 'transaction_id', 'billing_name', 'billing_email', 'billing_phone', 'billing_zip',
        'billing_locality', 'billing_street', 'billing_city', 'billing_state',
        'billing_landmark', 'billing_alternate_phone', 'company_name', 'gst_no',
        'shipping_same_as_billing', 'shipping_name', 'shipping_email', 'shipping_phone',
        'shipping_zip', 'shipping_locality', 'shipping_street', 'shipping_city', 'shipping_state',
        'shipping_landmark', 'shipping_alternate_phone',
        'subtotal', 'total', 'refunded_amount', 'payment_method', 'payment_status', 'order_status', 'token', 'awb_partner', 'awb_number', 'order_sl_no', 'is_modified',
    ];

    protected $casts = [
        'order_date' => 'datetime',
        'refunded_amount' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            // If not already set, auto-generate
            if (empty($order->order_number)) {
                $order->order_number = 'SW-'.now()->format('Ymd').'-'.strtoupper(Str::random(6));
            }

            // Always set order_date if not provided
            if (empty($order->order_date)) {
                $order->order_date = now();
            }
        });
    }

    public function orderitems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviews()
    {
        return $this->hasMany(Productreview::class);
    }

    public function paymentStatusStyle(): array
    {
        return match ($this->payment_status) {
            'processing' => [
                'bg' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
            ],
            'success' => [
                'bg' => 'bg-green-100 text-green-700 border-green-300',
            ],
            'refunded' => [
                'bg' => 'bg-amber-100 text-amber-700 border-amber-300',
            ],
            'cancelled' => [
                'bg' => 'bg-red-100 text-red-700 border-red-300',
            ],
            default => [
                'bg' => 'bg-gray-100 text-gray-700 border-gray-300',
            ],
        };
    }

    public function paymentStatusLabel(): string
    {
        return match ($this->payment_status) {
            'processing' => 'Processing',
            'success' => 'Success',
            'refunded' => 'Refunded',
            'cancelled' => 'Cancelled',
            default => ucfirst((string) $this->payment_status),
        };
    }

    public function refundableAmountRemaining(): float
    {
        return max(0, (float) $this->total - (float) $this->refunded_amount);
    }

    public function netAmount(): float
    {
        if ($this->payment_status === 'refunded') {
            return max(0, (float) $this->total - (float) $this->refunded_amount);
        }

        if ($this->payment_status === 'success' && $this->order_status !== 'cancelled') {
            return (float) $this->total;
        }

        return 0.0;
    }

    public function canRefundPayment(): bool
    {
        return $this->order_status === 'cancelled' && $this->payment_status === 'success';
    }

    public function scopeFinancialLedger(Builder $query): Builder
    {
        return $query->where(function (Builder $query): void {
            $query->where(function (Builder $query): void {
                $query->where('payment_status', 'success')
                    ->where('order_status', '!=', 'cancelled');
            })->orWhere('payment_status', 'refunded');
        });
    }
}
