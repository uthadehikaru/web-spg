<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Auth;

class ApiController extends Controller
{
    public function product(Product $product){
        if (Auth::user()->cannot('api', Product::class)) {
            return abort(403);
        }

        $data = [
            'value' => $product->value,
            'name' => $product->name,
            'price' => $product->getRawOriginal('price'),
        ];
        return response()->json($data);
    }
}
