<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\StoreShopRequest;
use App\Models\Product;
use App\Models\Shop;
use App\Models\ShopAddress;
use App\Models\ShopProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $shops = Shop::with('address')->latest()->get();

        return view('shop.index', compact('shops'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::has('skus.warehouses')->whereHas('skus.warehouses', function ($query) {
            $query->where('owner', Auth::id());
        })->get();

        return view('shop.sections.upsert-shop', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShopRequest $request)
    {
        $shop = Shop::create([
            'name' => $request->input('name'),
            'created_by' => Auth::id(),
        ]);

        if ($request->file('image')) {
            $name = preg_replace('/\s+/', '', $shop->name).'_'.time();
            $folder = '/shops/'.$shop->id.'/';
            Helper::uploadOne($request->file('image'), $folder, 'public', $name);

            $filePath = $folder.$name.'.'.$request->file('image')->clientExtension();
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
                    'price' => $product['price'],
                ]);
            }
        }

        $message = 'New shop created successfully!';

        return redirect()->route('shops.index')->with('alert-success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $shop = Shop::with('address', 'skus')->find($id);
        if ($shop) {
            return view('shop.sections.view-shop', compact('shop'));
        } else {
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $shop = Shop::with('product')->find($id);
        if ($shop) {
            $products = Product::get();

            return view('shop.sections.upsert-shop', compact('shop', 'products'));
        } else {
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $shop = Shop::find($id);
        if ($shop) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255|unique:shops,name,'.$id,
                'image' => 'mimes:png,jpg,jpeg|max:2048',
                'addresses.*.house_no' => 'required',
                'addresses.*.area' => 'required',
                'addresses.*.city' => 'required',
                'addresses.*.pincode' => 'required',
                'addresses.*.state' => 'required',
                'addresses.*.country' => 'required',
                'products.*.product_id' => 'required',
                'products.*.qty' => 'required',
                'products.*.price' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $shop->update([
                'name' => $request->input('name'),
            ]);

            if ($request->file('image')) {
                $name = preg_replace('/\s+/', '', $shop->name).'_'.time();
                $folder = '/shops/'.$shop->id.'/';
                Helper::uploadOne($request->file('image'), $folder, 'public', $name);

                $filePath = $folder.$name.'.'.$request->file('image')->clientExtension();
                Shop::find($shop->id)->update(['image' => $filePath]);
            }

            if (count($request->input('addresses')) > 0) {
                ShopAddress::where('shop_id', $shop->id)->delete();
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
                ShopProduct::where('shop_id', $shop->id)->delete();
                $products = $request->input('products');
                foreach ($products as $product) {
                    ShopProduct::create([
                        'shop_id' => $shop->id,
                        'product_id' => $product['product_id'],
                        'stock_qty' => $product['qty'],
                        'price' => $product['price'],
                    ]);
                }
            }

            $message = 'Shop details updated successfully!';

            return redirect()->route('shops.index')->with('alert-success', $message);
        } else {
            $message = 'Shop not found';

            return redirect()->back()->with('alert-error', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $shop = Shop::find($id);
        if (! $shop) {
            return response()->json(['message' => 'Shop not found.'], 404);
        }
        ShopAddress::where('shop_id', $id)->delete();
        ShopProduct::where('shop_id', $id)->delete();
        $shop->delete();

        return response()->json(['message' => 'Shop deleted successfully.']);
    }

    public function searchShops(Request $request)
    {
        $searchTerm = $request->input('search');
        if ($searchTerm) {
            $shops = Shop::where('name', 'like', '%'.$searchTerm.'%')
                ->orWhereHas('address', function ($query) use ($searchTerm) {
                    $query->where('area', 'like', '%'.$searchTerm.'%')
                        ->orWhere('city', 'like', '%'.$searchTerm.'%')
                        ->orWhere('country', 'like', '%'.$searchTerm.'%')
                        ->orWhere('pincode', 'like', '%'.$searchTerm.'%');
                })
                ->orWhereHas('products', function ($query) use ($searchTerm) {
                    $query->where('name', 'like', '%'.$searchTerm.'%')
                        ->whereHas('shops.product', function ($pivotQuery) {
                            $pivotQuery->where('stock_qty', '>', 0);
                        });
                })->get();
            $returnHTML = view('search-card')->with('shops', $shops)->render();
            $response = [
                'success' => true,
                'data' => [
                    'html' => $returnHTML,
                ],
                'message' => 'shop list fetched successfully.',
            ];

            return response($response);
        } else {
            return response()->json(['message' => 'no search found.'], 404);
        }
    }
}
