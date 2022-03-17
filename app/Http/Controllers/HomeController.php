<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Auth;
use DB;

class HomeController extends Controller
{
    public function index(){
        if(Auth::check())
        return redirect('dashboard');
        else
        return redirect('login');
    }

    public function dashboard(){
        if(Auth::user()->is_admin){
            $data['all'] = DB::table('orders')->count();
            $data['synced'] = DB::table('orders')->whereNotNull('c_order_id')->count();
            $data['unsynced'] = DB::table('orders')->whereNull('c_order_id')->count();
            $data['users'] = User::count();
            $data['products'] = Product::count();
        }else{
            $data['all'] = DB::table('orders')->where('user_id',Auth::id())->count();
            $data['synced'] = DB::table('orders')->where('user_id',Auth::id())->whereNotNull('c_order_id')->count();
            $data['unsynced'] = DB::table('orders')->where('user_id',Auth::id())->whereNull('c_order_id')->count();
        }
        return view('dashboard', $data);
    }

    public function order(){
        return view('scan');
    }

    public function report(){
        if(Auth::user()->is_admin)
            $data['orders'] = Order::latest('date_ordered')->paginate(10);
        else
            $data['orders'] = Order::latest('date_ordered')->where('user_id',Auth::id())->paginate(10);
            
        return view('report', $data);
    }
}
