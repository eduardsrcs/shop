<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class BasketController extends Controller
{

    public function basket() {
        $orderId = session('orderId');
        $order = null;
        if(!is_null($orderId)){
            $order = Order::findOrFail($orderId);
        }
        return view('basket', compact('order'));
    }

    public function basketPlace() {
        return view('order');
    }

    public function basketAdd($productId) {
        $orderId = session('orderId');

        if(is_null($orderId)) {
            $order = Order::create();
            session(['orderId' => $order->id]);
        } else {
            $order = Order::find($orderId);
        }
        $order->products()->attach($productId);
        return redirect(route('basket'));
    }

    public function basketRemove($productId) {
        $orderId = session('orderId');

        if(is_null($orderId)) {
            return redirect(route('basket'));
        }
        $order = Order::find($orderId);
        $order->products()->detach($productId);
        return redirect(route('basket'));
    }

}
