<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scan;
use Auth;

class HomeController extends Controller
{
    public function index(){
        if(Auth::check())
        return redirect('dashboard');
        else
        return redirect('login');
    }

    public function dashboard(){
        return view('dashboard');
    }

    public function order(){
        return view('scan');
    }

    public function report(){
        $data['orders'] = Scan::latest()->get();
        return view('report', $data);
    }

    public function sync(){
        return view('sync');
    }
}
