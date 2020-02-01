<?php

namespace App\Http\Controllers;

use Auth;
use App\Order;
use App\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function new(Request $request){
        $info = request()->only('name', 'link', 'time', 'number');

        $user = Order::create([
            'user_id' => $request->user()->id,
            'name' => $info['name'],
            'photo_link' => $info['link'],
            'rental_days' => $info['time'],
            'in_stock' => $info['number'],
        ]);
    }
}
