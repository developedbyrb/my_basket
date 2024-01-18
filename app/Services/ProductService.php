<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductService
{
    public function addProductCategory(Product $product, Request $request)
    {
        $product->categories()->attach($request->input('categories'));

        return $product;
    }
}
