<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $connection = 'old_mysql'; // 👈 important
    protected $table = 'tbl_order_details';

    public $timestamps = false; // if old DB doesn't have timestamps
    
    public function order()
    {
        return $this->belongsTo(
            Order::class,
            'order_id',
            'id'
        );
    }
}