<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()->where('user_id', auth()->user()->id);

        if ($request->status) {
            $orders->where('status', $request->status);
        }
        $orders = $orders->get();

        $ordersPending = Order::where('status', 1)->where('user_id', auth()->user()->id)->count();
        $ordersRecived = Order::where('status', 2)->where('user_id', auth()->user()->id)->count();
        $ordersSended = Order::where('status', 3)->where('user_id', auth()->user()->id)->count();
        $ordersDelivered = Order::where('status', 4)->where('user_id', auth()->user()->id)->count();
        $ordersCanceled = Order::where('status', 5)->where('user_id', auth()->user()->id)->count();

        return view('orders.index', compact('orders', 'ordersPending', 'ordersRecived', 'ordersSended', 'ordersDelivered', 'ordersCanceled'));
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
