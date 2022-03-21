<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessOrder;
use App\Jobs\CancelOrder;
use App\Models\Order;
use Auth;
use DB;
use Artisan;

class SyncController extends Controller
{
    public function index(){
        if (Auth::user()->cannot('sync', Auth::user())) {
            return abort(403);
        }

        $data['jobs'] = DB::table('jobs')->count();
        $data['failedJobs'] = DB::table('failed_jobs')->where('queue','order')->get();
        return view('sync',$data);
    }

    public function sync()
    {
        if (Auth::user()->cannot('sync', Auth::user())) {
            return abort(403);
        }

        $orders = Order::whereIn('status',['draft','error'])->get();
        $count = 0;
        foreach($orders as $order){
            if(!$order->job){
                $job = new ProcessOrder($order);
                $order->job_id = app(\Illuminate\Contracts\Bus\Dispatcher::class)->dispatch($job);
                $order->status = 'processing';
                $order->save();
                $count++;
            }
        }

        return back()->with('message',$count.' Jobs Created');
    }

    public function cancel($order_no)
    {
        $order = Order::with('user')->where('order_no',$order_no)->first();
        if($order==null)
            abort(404);
        
        CancelOrder::dispatchSync($order);

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
