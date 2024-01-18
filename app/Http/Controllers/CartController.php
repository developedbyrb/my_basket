<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role->id == 3) {
            $cartItems = Cart::with('sku.product')->where('created_by', Auth::id())->get();
        } else {
            $cartItems = Cart::with('shop', 'product.shopProduct')->where('created_by', Auth::id())->get();
        }

        return view('product.sections.view-cart', compact('cartItems'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $roleId = Auth::user()->role->id;
        if ($roleId === 3) {
            $skuId = $request->input('skuId');
            Cart::create([
                'qty' => 1,
                'sku_id' => $skuId,
                'created_by' => Auth::id(),
            ]);

            $message = 'Item added to cart successfully.';

            return redirect()->back()->with('alert-success', $message);
        } else {
            $shopId = $request->input('shopId');
            $skuId = $request->input('skuId');
            Cart::create([
                'qty' => 1,
                'shop_id' => $shopId,
                'sku_id' => $skuId,
                'created_by' => Auth::id(),
            ]);
            $message = 'Item added to cart successfully.';

            return redirect()->back()->with('alert-success', $message);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $cartData = $request->input('cart');
        if ($cartData && count($cartData) > 0) {
            foreach ($cartData as $key => $value) {
                Cart::find($key)->update($value);
            }

            return redirect()->route('orders.create')->with('alert-success', 'Items proceed to checkout successfully');
        } else {
            return redirect()->back()->with('alert-error', 'Please add items to the cart to proceed.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Cart::findOrFail($id)->delete();
        $message = 'Product removed from cart.';

        return response()->json(['success' => true, 'message' => $message]);
    }
}
