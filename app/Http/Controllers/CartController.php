<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;


class CartController extends Controller
{
    public function store(Request $request, int $product_id) {
        $product = Product::find($product_id);

        if(!$product) {
            return response()->json([
                "message"=> "Not found",
            ], 404);
        }

        $cart = Cart::create([
            "user_id" => $request->user()->id,
            "product_id" => $product->id,
        ]);

        return response()->json([
            'message' => 'Product add to cart',
        ], 201);
    }

    public function index(Request $request, ) {
        $cart = Cart::where('user_id', $request->user()->id)
            ->with('product')
            ->get();

        return response()->json(
            $cart->map(function ($item) {
                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'name' => $item->product->name,
                    'description' => $item->product->description,
                    'price' => $item->product->price,
                ];
            })
        );
    }

    public function destroy(Request $request, int $id) {
        $cartItem = Cart::find($id);

        if(!$cartItem) {
            return response()->json([
                'message'=> 'Forbidden for you',
            ],403);
        }

        if($cartItem->user_id !== $request->user()->id) {
            return response()->json([
                'message'=> 'Forbidden for you',
            ],403);
        }

        $cartItem->delete();

        return response()->json([
            'message'=> 'Item removed from cart',
        ],200);
    }
}
