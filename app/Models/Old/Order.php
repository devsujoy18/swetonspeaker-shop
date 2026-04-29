<?php

namespace App\Models\Old;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $connection = 'old_mysql'; // 👈 important
    protected $table = 'tbl_order_basic';

    public $timestamps = false; // if old DB doesn't have timestamps
    
    // 🔗 Relation: Order has many details
    public function details()
    {
        return $this->hasMany(
            OrderDetail::class,
            'order_id',   // FK in tbl_order_details
            'id'          // PK in tbl_order_basic
        );
    }
}
