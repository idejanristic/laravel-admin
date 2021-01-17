<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderItemResource;

class OrderController extends Controller
{
    public function index() 
    {
        $oreders = Order::paginate();

        return OrderResource::collection($oreders);
    }

    public function show()
    {
        return new OrderResource(Order::find($id));
    }
}
