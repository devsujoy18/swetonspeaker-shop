<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'user_id','order_number','razorpay_order_id','transaction_id','billing_name','billing_email','billing_phone','billing_zip',
        'billing_locality','billing_street','billing_city','billing_state',
        'billing_landmark','billing_alternate_phone','company_name','gst_no',
        'shipping_same_as_billing','shipping_name','shipping_email','shipping_phone',
        'shipping_zip','shipping_locality','shipping_street','shipping_city','shipping_state',
        'shipping_landmark','shipping_alternate_phone',
        'subtotal','total','payment_method','payment_status','order_status','token','awb_partner','awb_number','order_sl_no','is_modified'
    ];

    protected $casts = [
        'order_date' => 'datetime',
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            // If not already set, auto-generate
            if (empty($order->order_number)) {
                $order->order_number = 'SW-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
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
}
