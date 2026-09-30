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
}
