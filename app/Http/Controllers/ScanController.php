<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderLine;
use Carbon\Carbon;
use Auth;
use Str;
use Gate;

class ScanController extends Controller
{
    public function index(Request $request){
        if (Auth::user()->cannot('create', Order::class)) {
            return abort(403);
        }
        return view('scan');
    }

    public function submit(Request $request){
        $data = $request->all();
        if(count($data['product_code'])>1){
            $order = Order::create([
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                'order_no'=>Str::random(5),
                'date_ordered'=>date('Y-m-d'),
                'user_id'=>Auth::id(),
            ]);
            $products = [];
            for($i=0;$i<count($data['product_code']);$i++){
                if($i==0)
                    continue;

                $products[] = [
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                    'product_code'=>$data['product_code'][$i],
                    'quantity'=>$data['quantity'][$i],
                    'order_id'=>$order->id,
                ];
            }
            OrderLine::insert($products);
            return redirect()->route('report');
        }
    }
}
