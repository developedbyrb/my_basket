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
        if ($request->ajax()) {
            $returnHTML = view('product.partials.tableRows')->with('products', $products)->render();
            $response = [
                'success' => true,
                'data' => [
                    'html' => $returnHTML
                ],
                'message' => 'Product list fetched successfully.'
            ];
            return response($response);
        }
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::select('id', 'name')->get();
        return view('product.partials.upsertProduct', compact('categories'));
        // $returnHTML = view('product.partials.addCategories')->with('categories', $categories)->render();
        // $response = [
        //     'success' => true,
        //     'data' => [
        //         'html' => $returnHTML
        //     ],
        //     'message' => 'Product form data fetch successfully.'
        // ];
        // return response($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request, ProductService $productService): Response
    {
        $product = Product::create($request->validated());

        $uploadedImage = '/' . $this->upload($request, 'image', 'products', $product);
        Product::find($product->id)->update(['image' => $uploadedImage]);

        $productService->addProductCategory($product, $request);
        return response(['message' => 'Product Created Successfully', 'success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $shopId = $request->input('shop_id');
        $product = ShopProduct::with('productDetails')->where('product_id', $id)->where('shop_id', $shopId)->first();
        $returnHTML = view('product.partials.addToCartTable')->with('product', $product)->render();
        $response = [
            'success' => true,
            'data' => [
                'html' => $returnHTML
            ],
            'message' => 'Product Details fetch successfully.'
        ];
        return response($response);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);
        $categories = Category::select('id', 'name')->get();
        $returnHTML = view('product.partials.addCategories')
            ->with(['categories' => $categories, 'product' => $product])->render();
        $response = [
            'success' => true,
            'data' => [
                'html' => $returnHTML,
                'productData' => $product
            ],
            'message' => 'Product edit form data fetch successfully.'
        ];
        return response($response);
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

    public function addToCart(Request $request, string $id): JsonResponse
    {
        $shopId = $request->input('shopId');
        $product = ShopProduct::with('productDetails', 'shopDetails')
            ->where('product_id', $id)->where('shop_id', $shopId)->first();
        $cart = session()->get('cart', []);
        if (isset($cart[$id . '-' . $shopId]) && isset($cart[$id . '-' . $shopId]['shopId']) && $cart[$id . '-' . $shopId]['shopId'] === $shopId) {
            $cart[$id . '-' . $shopId]['quantity']++;
            $price = $product->price * $cart[$id . '-' . $shopId]['quantity'];
            $cart[$id . '-' . $shopId]['price'] = $price;
        } else {
            $price = $product->price * $request->input('added_qty');
            $cart[$id . '-' . $shopId] = [
                "name" => $product->productDetails->name,
                "quantity" => $request->input('added_qty'),
                "shopId" => $shopId,
                "productId" => $id,
                "shopName" => $product->shopDetails->name,
                "price" => $price,
                "image" => $product->productDetails->image
            ];
        }
        session()->put('cart', $cart);
        return response()->json(['success' => true, 'message' => 'Product added to cart!']);
    }
}
