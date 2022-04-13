<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function pay(Order $order, Request $request)
    {
        $payment_id = $request->payment_id;

        $response = Http::get("https://api.mercadopago.com/v1/payments/$payment_id" . "?access_token=". env('MP_ACCESS_TOKEN'));
        $response = json_decode($response);
        
        $status = $response->status;

        if ($status =='approved') {
            $order->status = 2;
            $order->save();
            
            return redirect()->route('orders.show', $order);
        }
    }
}
