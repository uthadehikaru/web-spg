<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessOrder;
use App\Models\Order;

class SyncController extends Controller
{
    public function index(){
        $data['orders'] = Order::latest()->paginate(10);
        return view('sync',$data);
    }

    public function sync($order_no)
    {
        $order = Order::where('order_no',$order_no)->first();
        if($order==null)
            abort(404);
        
        ProcessOrder::dispatch($order);

        return redirect()->route('sync');
    }

    public function delete($order_no)
    {
        $order = Order::where('order_no',$order_no)->first();
        $order->lines()->delete();
        $order->delete();
        return redirect()->route('sync');
    }
}
