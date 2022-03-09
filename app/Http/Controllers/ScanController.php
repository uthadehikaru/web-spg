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
        $total = 0;
        $user = Auth::user();
        if(count($data['product_code'])>1){
            $order = Order::create([
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                'order_no'=>Str::random(5),
                'ad_user_id' => $user->user_id,
                'user_name' => $user->name,
                'campaign_id' => $user->campaign_id,
                'campaign_name' => $user->campaign_name,
                'doctype_id' => $user->doctype_id,
                'doctype_name' => $user->doctype_name,
                'customer_id' => $user->customer_id,
                'customer_name' => $user->customer_name,
                'location_id' => $user->location_id,
                'location_name' => $user->location_name,
                'warehouse_id' => $user->warehouse_id,
                'warehouse_name' => $user->warehouse_name,
                'pricelist_id' => config('idempiere.pricelist'),
                'date_ordered'=>date('Y-m-d'),
                'user_id'=>Auth::id(),
            ]);
            $products = [];
            for($i=0;$i<count($data['product_code']);$i++){
                if($i==0)
                    continue;

                $totalLine = $data['quantity'][$i]*$data['price'][$i];
                $products[] = [
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                    'product_code'=>$data['product_code'][$i],
                    'quantity'=>$data['quantity'][$i],
                    'price'=>$data['price'][$i],
                    'total'=>$totalLine,
                    'order_id'=>$order->id,
                ];
                $total += $totalLine;
            }
            OrderLine::insert($products);

            $order->grandtotal = $total;
            $order->save();

            return redirect()->route('report');
        }
    }
}
