<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return view('report');
    }

    public function sync(){
        return view('sync');
    }
}
