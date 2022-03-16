<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessOrder;
use App\Models\Order;
use Auth;

class SyncController extends Controller
{
    public function index(){
        if (Auth::user()->cannot('sync', Auth::user())) {
            return abort(403);
        }

        $data['orders'] = Order::latest()->paginate(10);
        return view('sync',$data);
    }

    public function sync($order_no)
    {
        $order = Order::with('user')->where('order_no',$order_no)->first();
        if($order==null)
            abort(404);
        
        ProcessOrder::dispatchSync($order);

        return back();
    }

    public function delete($order_no)
    {
        $order = Order::whereNull('c_order_id')->where('order_no',$order_no)->first();

        if(Auth::user()->is_admin || Auth::id()==$order->user_id){
            $order->lines()->delete();
            $order->delete();
            return back()->with('message','Order has been deleted');
        }

        return abort(403);
    }
}
