<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scan;
use Carbon\Carbon;
use Auth;

class ScanController extends Controller
{
    public function index(){
        return view('scan');
    }

    public function submit(Request $request){
        $data = $request->all();
        $products = [];
        for($i=0;$i<count($data['product_code']);$i++){
            if($i==0)
                continue;

            $products[] = [
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now(),
                'product_code'=>$data['product_code'][$i],
                'quantity'=>$data['quantity'][$i],
                'user_id'=>Auth::id(),
            ];
        }
        Scan::insert($products);
        return redirect()->route('report');
    }
}
