<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ShopProduct;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $orders = Order::with('orderDetail')->where('order_by', Auth::id())->get();
        return view('order.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): RedirectResponse | View
    {
        if (Auth::user()->role->id == 3) {
            $cartItems = Cart::with('sku.product')->where('created_by', Auth::id())->get();
        } else {
            $cartItems = Cart::with('shop', 'product.shopProduct')->where('created_by', Auth::id())->get();
        }
        if (count($cartItems) > 0) {
            foreach ($cartItems as $cartItem) {
                $cartItem->update([
                    'expected_delivery_date' => Carbon::today()->addDays(rand(0, 8))
                ]);
            }
            return view('order.checkout', compact('cartItems'));
        } else {
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $cart = Cart::with('shop', 'product.shopProduct')->where('created_by', Auth::id())->get();
        foreach ($cart as $value) {
            $order = Order::create([
                'expected_delivery_date' => $value['expected_delivery_date'],
                'payment_type' => $validatedData['payment_type'],
                'qty' => $value['qty'],
                'total_amount' => $value['qty'] * $value->product->shopProduct[0]->price,
                'shop_id' => $value['shop_id'],
                'product_id' => $value['product_id'],
                'order_by' => Auth::id(),
                'status' => 1
            ]);

            OrderDetail::create([
                'order_id' => $order->id,
                'house_no' => $validatedData['addresses'][0]['house_no'],
                'area' => $validatedData['addresses'][0]['area'],
                'city' => $validatedData['addresses'][0]['city'],
                'pincode' => $validatedData['addresses'][0]['pincode'],
                'state' => $validatedData['addresses'][0]['state'],
                'country' => $validatedData['addresses'][0]['country']
            ]);

            $shopDetails = ShopProduct::where('shop_id', $value['shop_id'])
                ->where('product_id', $value['product_id'])->first();
            $updatedQty = $shopDetails->stock_qty - $value['qty'];
            $shopDetails->update([
                'stock_qty' => $updatedQty
            ]);
        }

        Cart::where('created_by', Auth::id())->delete();

        $message = 'Order placed successfully';
        return redirect()->route('orders.index')->with('alert-success', $message);
    }

    public function getCartDetails(): View
    {
        if (Auth::user()->role->id == 3) {
            $cartItems = Cart::with('sku.product')->where('created_by', Auth::id())->get();
        } else {
            $cartItems = Cart::with('shop', 'product.shopProduct')->where('created_by', Auth::id())->get();
        }
        return view('product.sections.view-cart', compact('cartItems'));
    }

    public function addToCart(Request $request, string $id): RedirectResponse | JsonResponse
    {
        $roleId = Auth::user()->role->id;
        if ($roleId === 3) {
            Cart::create([
                'qty' => 1,
                'sku_id' => $id,
                'created_by' => Auth::id()
            ]);

            $message = "Item added to cart successfully.";
            return redirect()->back()->with('alert-success', $message);
        } else {
            $shopId = $request->input('shopId');
            Cart::create([
                'qty' => $request->input('added_qty'),
                'shop_id' => $shopId,
                'product_id' => $id,
                'created_by' => Auth::id()
            ]);
            return response()->json(['success' => true, 'message' => 'Product added to cart!']);
        }
    }

    public function destroy(Request $request, string $id): JsonResponse
    {
        $orderDetails = Order::find($id);
        if ($orderDetails) {
            $shopDetails = ShopProduct::where('shop_id', $orderDetails->shop_id)
                ->where('product_id', $orderDetails->product_id)->first();
            if ($shopDetails) {
                $updatedQty = $shopDetails->stock_qty + $orderDetails->qty;
                $shopDetails->update(['stock_qty' => $updatedQty]);
            }
            $orderDetails->update([
                'status' => 4,
                'cancelled_reason' => $request->input('reason')
            ]);

            if ($request->file('cancelled_reason_image')) {
                $name = preg_replace('/\s+/', '', $orderDetails->id) . '_' . time();
                $folder = '/cancel-orders/' . $orderDetails->id . '/';
                Helper::uploadOne($request->file('cancelled_reason_image'), $folder, 'public', $name);

                $filePath = $folder . $name . '.' . $request->file('cancelled_reason_image')->clientExtension();
                Order::find($id)->update(['cancelled_reason_image' => $filePath]);
            }
            return response()->json(['message' => 'record deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'order not found'], 400);
        }
    }

    public function destroyCartItem(Request $request, $id)
    {
        $cartItem = Cart::findOrFail($id)->delete();
        // $cartItem->delete();
        $message = 'Product removed from cart.';

        return redirect()->back()->with('alert-success', $message);
    }

    public function cartCheckout(Request $request)
    {
        $cartData = $request->input('cart');
        if (count($cartData) > 0) {
            foreach ($cartData as $key => $value) {
                Cart::find($key)->update($value);
            }

            return redirect()->route('orders.create')->with('alert-success', 'Items proceed to checkout successfully');
        } else {
            return redirect()->back()->with('alert-error', 'Something went wrong.');
        }
    }
}
