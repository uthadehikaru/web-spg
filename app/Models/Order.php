<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_no',
        'ad_user_id',
        'user_name',
        'campaign_id',
        'campaign_name',
        'doctype_id',
        'doctype_name',
        'customer_id',
        'customer_name',
        'location_id',
        'location_name',
        'warehouse_id',
        'warehouse_name',
        'pricelist_id',
        'date_ordered',
        'user_id',
        'c_order_id',
        'c_order_no',
        'grandtotal',
    ];
    
    protected $casts = [
        'date_ordered' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lines()
    {
        return $this->hasMany(OrderLine::class);
    }
}
