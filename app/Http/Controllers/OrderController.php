<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
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

    public function export()
    {
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=orders.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () {
            $oreders = Order::all();
            $file = \fopen('php://output', 'w');

            fputcsv($file, ['ID', 'Name', 'Email', 'Product title', 'Price', 'Quantity']);

            foreach($oreders as $order) 
            {
                fputcsv($file, [$order->id, $order->name, $order->email, '', '', '']);

                foreach($order->orderItems as $orderItem) 
                {
                    fputcsv($file, ['', '', '', $orderItem->product_title, $orderItem->price, $orderItem->quantity]);
                }
            }
            
            \fclose($file);
        };

        return \Response::stream($callback, 200, $headers);
    }
}
