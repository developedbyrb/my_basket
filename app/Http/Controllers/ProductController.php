<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\StoreProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ShopProduct;
use App\Services\ProductService;
use App\Traits\ImageUpload;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    use ImageUpload;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View | Response
    {
        $products = Product::latest()->get();
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::select('id', 'name')->get();
        return view('product.sections.upsert-product', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        $product = Product::create($request->validated());

        // upload product image
        $uploadedImage = '/' . $this->upload($request, 'image', 'products', $product);
        Product::find($product->id)->update(['image' => $uploadedImage]);

        $message = 'Product created successfully';
        return redirect()->route('products.index')->with('alert-success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $productDetails = Product::with([
            'skus.attributeOptions' => function ($query) {
                $query->with('attribute')->orderBy('id', 'desc');
            }
        ])->with('details', 'categories')->find($id);
        $fields = [];
        $attributeColumns = $productDetails->skus[0]->attributeOptions;
        foreach ($attributeColumns as $key => $value) {
            array_push($fields, $value->attribute->name);
        }
        return view('product.sections.view-product', compact('productDetails', 'fields'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $productDetails = Product::with('details', 'categories')->find($id);
        $categories = Category::select('id', 'name')->get();
        return view('product.sections.upsert-product', compact('productDetails', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'categories' => 'required',
            'image' => 'mimes:png,jpg,jpeg|max:2048',
        ]);

        $product = Product::find($id);
        if ($product) {
            $product->update([
                'name' => $request->input('name'),
            ]);

            if ($request->file('image')) {
                $name = preg_replace('/\s+/', '', $product->name) . '_' . time();
                $folder = '/products/' . $product->id . '/';
                Helper::uploadOne($request->file('image'), $folder, 'public', $name);

                $filePath = $folder . $name . '.' . $request->file('image')->clientExtension();
                Product::find($product->id)->update(['image' => $filePath]);
            }

            if (count($request->input('categories')) > 0) {
                //remove all product categories
                ProductCategory::where('product_id', $product->id)->delete();
                //add updated product categories
                $category = $request->input('categories');
                $categoryArray = explode(",", $category[0]);
                foreach ($categoryArray as $category) {
                    ProductCategory::create([
                        'product_id' => $product->id,
                        'category_id' => $category
                    ]);
                }
            }
            return response(['message' => 'Product update Successfully', 'success' => true]);
        } else {
            return response()->json(['message' => 'Product not found.'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found.'], 404);
        }
        ProductCategory::where('product_id', $id)->delete();
        ShopProduct::where('product_id', $id)->delete();
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully.']);
    }

    /**
     * return html for a listing of the variants.
     */
    public function getProductAttributes(Request $request)
    {
        $variants = Category::with('attributes.attributeOptions')
            ->findMany($request->input('categories'))
            ->pluck('attributes')
            ->flatten()
            ->unique('id');
        if (count($variants) > 0) {
            $returnHTML = view('product.partials.add-variants')->with('variants', $variants)
                ->render();
            $response = [
                'success' => true,
                'data' => [
                    'html' => $returnHTML
                ],
                'message' => 'Product attributes list fetched successfully.'
            ];
            return response()->json($response);
        } else {
            return redirect()->back();
        }
    }
}
