<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'quantity',
        'order_id',
        'price',
        'total',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
