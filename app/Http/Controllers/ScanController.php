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
        $data['order'] = null;
        return view('scan', $data);
    }

    public function edit(Request $request, Order $order){
        if (Auth::user()->cannot('edit', $order)) {
            return abort(403);
        }
        $data['order'] = $order;
        return view('scan', $data);
    }

    public function submit(Request $request){
        if (Auth::user()->cannot('create', Order::class)) {
            return abort(403);
        }

        $request->validate([
            'date_ordered' => 'required|date',
        ]);
        $data = $request->all();

        $total = 0;
        $user = Auth::user();

        $order = Order::where([
            'customer_id' => $user->customer_id,
            'location_id' => $user->location_id,
            'date_ordered'=>$data['date_ordered'],
        ])->first();

        if($order)
            return redirect()->route('report')->with('error','Order already exists. Order No. '.$order->order_no);

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
                'date_ordered'=>$data['date_ordered'],
                'user_id'=>Auth::id(),
            ]);
            $products = [];
            for($i=0;$i<count($data['product_code']);$i++){
                if($i==0)
                    continue;

                $price = str_replace('.','',$data['price'][$i]);
                $totalLine = $data['quantity'][$i]*$price;
                $products[] = [
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                    'product_code'=>$data['product_code'][$i],
                    'product_name'=>$data['product_name'][$i],
                    'quantity'=>$data['quantity'][$i],
                    'price'=>$price,
                    'total'=>$totalLine,
                    'order_id'=>$order->id,
                ];
                $total += $totalLine;

            }
            OrderLine::insert($products);

            $order->grandtotal = $total;
            $order->save();

            return redirect()->route('report')->with('message','Order Created');
        }
    }

    public function update(Request $request, Order $order){
        if (Auth::user()->cannot('edit', $order)) {
            return abort(403);
        }

        $data = $request->all();

        $total = 0;
        $user = Auth::user();

        if(count($data['product_code'])>1){
            
            $products = [];
            for($i=0;$i<count($data['product_code']);$i++){
                if($i==0)
                    continue;

                $price = str_replace('.','',$data['price'][$i]);
                $totalLine = $data['quantity'][$i]*$price;

                $line_id = $data['id'][$i];
                $is_deleted = $data['is_deleted'][$i];
                if($line_id>0 && $is_deleted){
                    OrderLine::find($line_id)->delete();
                }elseif($line_id>0){
                    $products = [
                        'updated_at'=>Carbon::now(),
                        'quantity'=>$data['quantity'][$i],
                        'price'=>$price,
                        'total'=>$totalLine,
                    ];
                    OrderLine::find($line_id)->update($products);
                }else{
                    $products = [
                        'created_at'=>Carbon::now(),
                        'updated_at'=>Carbon::now(),
                        'product_code'=>$data['product_code'][$i],
                        'product_name'=>$data['product_name'][$i],
                        'quantity'=>$data['quantity'][$i],
                        'price'=>$price,
                        'total'=>$totalLine,
                        'order_id'=>$order->id,
                    ];
                    $line = OrderLine::insert($products);
                }
                
                if(!$is_deleted)
                    $total += $totalLine;
            }

            $order->grandtotal = $total;
            $order->save();

            return redirect()->route('report')->with('message','Order Updated');
        }
    }
}
