<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request) {
        $user = $request->user();

        $cartItems = Cart::where("user_id", $user->id)
            ->with('product')
            ->get();

        if($cartItems->isEmpty()) {
            return response()->json([
                'error' => [
                    'code' => 422,
                    'message' => 'Cart is empty',
                ],
            ], 422);
        }

        $order = Order::create([
            'user_id' => $user->id,
        ]);

        foreach($cartItems as $cartItem) {
            $order->items()->create([
                'product_id' => $cartItem->product_id,
                'name' => $cartItem->product->name,
                'description' => $cartItem->product->description,
                'price' => $cartItem->product->price,
            ]);
        }

        Cart::where('user_id', $user->id)->delete();

        return response()->json([
            'order_id' => $order->id,
            'message' => 'Order is processed',
        ], 201);
    }

    public function index(Request $request) {
        $orders = Order::where('user_id', $request->user()->id)
            ->with('items')
            ->get();

        return response()->json(
            $orders->map(function($order) {

                return [
                    'id' => $order->id,
                    'products' => $order->items->pluck('product_id')->values(),
                    'order_price' => $order->items->sum('price'),
                ];
            }), 200
        );
    }
}