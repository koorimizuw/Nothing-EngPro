<?php

namespace App\Http\Controllers;

use Auth;
use App\Order;
use App\Stock;
use App\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function new(Request $request){
        $info = request()->only('name', 'link', 'time', 'number');

        Stock::create([
            'user_id' => $request->user()->id,
            'name' => $info['name'],
            'photo_link' => $info['link'],
            'rental_days' => $info['time'],
            'in_stock' => $info['number'],
        ]);

        return [
            'Message' => 'Add successful.'
        ];
    }

    function list(){
        return Stock::all();
    }

    function search(Request $request){
        $key = request()->key;
        $res = Stock::where('name', 'like', '%'.$key.'%')
                        ->get();
        return $res;
    }

    function order(Request $request){
        $id = $request->id;
        Order::create([
            'user_id' => $request->user()->id,
            'stock_id' => $id,
        ]);

        return [
            'Message' => 'Order successful.'
        ];
    }
}
