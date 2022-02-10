<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Present;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function index(){
        return view('welcome');
    }
}
