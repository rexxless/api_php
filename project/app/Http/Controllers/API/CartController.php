<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartItemResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;

class CartController extends Controller
{


    public function show()
    {
        $cart = Cart::where('user_id', auth()->id())->first();


        $result = [];

        foreach ($cart->products as $index => $productId) {
            $product = Product::find((int)$productId);

            if ($product) {
                $result[] = [
                    'id' => $index + 1,
                    ...(new CartItemResource($product))->toArray(request())
                ];
            }
        }

        return $result;
    }

    public function store(Request $request, $id)
    {
        if (!Product::where('id', $id)->exists()) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['products' => []]
        );

        $products = $cart->products ?? [];

        $products[] = (int)$id;

        $cart->update(['products' => $products]);

        return response()->json([
            'message' => 'Product add to cart',
        ], 201);
    }



    public function destroy($id)
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        $products = $cart->products;

        if (!isset($products[$id-1])) {
            return response()->json(["message" => "Item not found"], 404);
        }

        array_splice($products, $id-1, 1);

        $cart->update(['products' => $products]);

        return response()->json([
            "message" => "Item removed from cart",
        ]);
    }



}
