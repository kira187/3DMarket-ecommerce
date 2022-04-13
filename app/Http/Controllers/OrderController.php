<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function index()
    {
        return view('orders.index');
    }

    public function show(Order $order)
    {
        $this->authorize('author', $order);
        $items = json_decode($order->content);
        return view('orders.show', compact('order', 'items'));
    }

    /**
     * Metodo que sera utilizado en produccion para el webhook
     */
    public function pay(Order $order, Request $request)
    {
        $this->authorize('author', $order);
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
