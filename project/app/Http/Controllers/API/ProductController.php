<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $product = Product::query()->create($request->validated());
        return response(['id' => $product->id, 'message' => 'Product added'], 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, $id)
    {
        Product::query()->where('id', $id)-> update($request->validated());

        return response()->json([
            'data' => new ProductResource(Product::query()->find($id)),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        if (!auth()->user()->is_admin) {
            response()->json(['message' => 'Forbidden for you'], 403)->send();
            exit;
        }


        if (Product::query()->where('id', $id)->delete() != 1)
        {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json(['message' => 'Product removed']);
    }
}
