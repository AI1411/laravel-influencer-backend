<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ProductsController extends Controller
{

    public function index()
    {
        Gate::authorize('view', 'products');

        $products = Product::paginate();

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('edit', 'products');

        $product = $request->only('title', 'description', 'image', 'price');

        return response(new ProductResource($product), Response::HTTP_CREATED);
    }


    /**
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product)
    {
        Gate::authorize('view', 'products');

        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        Gate::authorize('edit', 'products');

        $product->update($request->only('title', 'description', 'image', 'price'));

        return response(new ProductResource($product), Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Gate::authorize('edit', 'products');
        Product::destroy($product);

        return \response(null, Response::HTTP_NO_CONTENT);
    }
}
