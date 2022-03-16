<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\GetSales;
use App\Models\User;
use Auth;

class UserController extends Controller
{
    public function index(){
        if (Auth::user()->cannot('list', Auth::user())) {
            return abort(403);
        }
        $data['users'] = User::orderBy('name')->paginate(10);
        $data['total'] = User::count();
        return view('user',$data);
    }

    public function sync()
    {    
        if (Auth::user()->cannot('sync', Auth::user())) {
            return abort(403);
        }
        GetSales::dispatch();

        return back();
    }
}
