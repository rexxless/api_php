<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Resources\CartItemResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return Order::query()->where('user_id', auth()->id())->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create_order()
    {
        $cart = Cart::where('user_id', auth()->id())->first();
        if ($cart->products == [])
        {
            return response()->json([
                'error'=>['code'=>422, 'message'=>'Cart is empty'],
            ], 422);
        }

        $total = 0;

        foreach ($cart->products as $productId) {
            $product = Product::find((int)$productId);
            $total += $product->price;
        }


        $order = Order::query()->create([
            'user_id' => auth()->id(),
            'products' => $cart->products,
            'order_price' => $total,
        ]);
        return response()->json(['order_id'=> $order->id, 'message' => 'Order is processed'], 201);
    }
}
