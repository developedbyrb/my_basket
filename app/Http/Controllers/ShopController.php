<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use App\Models\ShopAddress;
use App\Models\ShopProduct;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $shops = Shop::with('address')->get();
        return view('shop.index', compact('shops'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::get();
        return view('shop.partials.upsert', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|mimes:png,jpg,jpeg|max:2048',
        ]);

        $shop = Shop::create([
            'name' => $request->input('name'),
            'created_by' => Auth::id()
        ]);

        if ($request->file('image')) {
            $name = preg_replace('/\s+/', '', $shop->name) . '_' . time();
            $folder = '/shop$shops/' . $shop->id . '/';
            $this->uploadOne($request->file('image'), $folder, 'public', $name);

            $filePath = $folder . $name . '.' . $request->file('image')->clientExtension();
            Shop::find($shop->id)->update(['image' => $filePath]);
        }

        if (count($request->input('addresses')) > 0) {
            $addresses = $request->input('addresses');
            foreach ($addresses as $address) {
                ShopAddress::create([
                    'shop_id' => $shop->id,
                    'house_no' => $address['house_no'],
                    'area' => $address['area'],
                    'city' => $address['city'],
                    'pincode' => $address['pincode'],
                    'state' => $address['state'],
                    'country' => $address['country'],
                ]);
            }
        }

        if (count($request->input('products')) > 0) {
            $products = $request->input('products');
            foreach ($products as $product) {
                ShopProduct::create([
                    'shop_id' => $shop->id,
                    'product_id' => $product['product_id'],
                    'stock_qty' => $product['qty'],
                    'price' => $product['price']
                ]);
            }
        }

        return redirect()->route('shops.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $shop = Shop::with('product')->find($id);
        if ($shop) {
            $products = Product::get();
            return view('shop.partials.upsert', compact('shop', 'products'));
        } else {
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $shop = Shop::find($id);
        if (!$shop) {
            return response()->json(['message' => 'Shop not found.'], 404);
        }
        ShopAddress::where('shop_id', $id)->delete();
        ShopProduct::where('shop_id', $id)->delete();
        $shop->delete();
        return response()->json(['message' => 'Shop deleted successfully.']);
    }

    public function getOptions()
    {
        $products = Product::select('id', 'name')->get();
        $returnHTML = view('shop.partials.options')->with('products', $products)->render();
        $response = [
            'success' => true,
            'data' => [
                'html' => $returnHTML
            ],
            'message' => 'Users list fetched successfully.'
        ];
        return response($response);
    }

    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);
        return $uploadedFile->storeAs($folder, $name . '.' . $uploadedFile->clientExtension(), $disk);
    }
}
