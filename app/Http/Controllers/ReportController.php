<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Auth;
use DB;

class ReportController extends Controller
{
    public function index(){
        $data['title'] = 'Reports';
        if(Auth::user()->is_admin)
            $data['orders'] = Order::latest('date_ordered')->paginate(10);
        else
            $data['orders'] = Order::latest('date_ordered')->where('user_id',Auth::id())->paginate(10);
            
        return view('report', $data);
    }

    public function detail(Order $order){
        if (Auth::user()->cannot('create', $order)) {
            return abort(403);
        }

        $data['order'] = $order;
        return view('detail-order', $data);
    }

    public function request(Order $order){
        if (Auth::user()->cannot('request', Order::class)) {
            return abort(403);
        }
        $data['title'] = "Cancel Order";
        $data['syncedOrders'] = Order::where('status','processed')->latest('date_ordered')->get();
        $data['orders'] = Order::where('status','cancel')->paginate(5);
        return view('request-order', $data);
    }

    public function cancel(Request $request){
        $data = $request->validate([
            'order_id' => 'required',
        ]);

        $order = Order::where('order_no',$request->order_id)->first();

        if (Auth::user()->cannot('cancel', $order)) {
            return abort(403);
        }

        $order->status = "cancel";
        $order->save();

        return back()->with('message','Order requested to be canceled');
    }

    public function reactive(Order $order){
        if (Auth::user()->cannot('reactive', $order)) {
            return abort(403);
        }

        $activeOrder = Order::where([
            'customer_id' => $order->customer_id,
            'location_id' => $order->location_id,
            'date_ordered'=>$order->date_ordered,
        ])->whereIn('status',['draft','processing','processed'])->first();
        if($activeOrder)
            return back()->with('error','Cannot reactive, Another active order is exists #'.$order->order_no);

        $order->status = "processed";
        $order->save();

        return back()->with('message','Order reactivated');
    }
}
