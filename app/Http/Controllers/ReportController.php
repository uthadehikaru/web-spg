<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Auth;
use DB;

class ReportController extends Controller
{
    public function index(){
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

    public function cancel(Order $order){
        if (Auth::user()->cannot('cancel', $order)) {
            return abort(403);
        }

        $order->is_canceled = true;
        $order->save();

        return back()->with('message','Order requested to be canceled');
    }
}
