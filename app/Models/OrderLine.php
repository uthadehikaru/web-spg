<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'product_name',
        'quantity',
        'order_id',
        'price',
        'total',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function getPriceAttribute($value)
    {
        return 'Rp '.number_format($value, 0, ",", ".");
    }

    public function getTotalAttribute($value)
    {
        return 'Rp '.number_format($value, 0, ",", ".");
    }
}
