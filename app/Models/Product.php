<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
        'name',
        'price',
        'is_active',
    ];

    public function getPriceAttribute($value)
    {
        return 'Rp '.number_format($value, 0, ",", ".");
    }
}
