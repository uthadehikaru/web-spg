<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'quantity',
        'user_id',
        'c_orderline_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
