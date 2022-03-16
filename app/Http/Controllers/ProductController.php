<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\GetProducts;
use App\Models\Product;
use Auth;

class ProductController extends Controller
{
    public function index(){
        if (Auth::user()->cannot('list', Product::class)) {
            return abort(403);
        }
        $data['products'] = Product::orderBy('value')->paginate(50);
        $data['total'] = Product::count();
        return view('product',$data);
    }

    public function sync()
    {    
        if (Auth::user()->cannot('sync', Product::class)) {
            return abort(403);
        }
        GetProducts::dispatch();

        return back();
    }
}
