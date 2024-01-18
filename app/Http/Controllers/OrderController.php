<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Cart;
use App\Models\Order;
use App\Models\ShopAddress;
use App\Models\ShopProduct;
use App\Models\Warehouse;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
    public function create(): RedirectResponse|View
    {
        $addresses = null;
        if (Auth::user()->role->id == 3) {
            $addresses = Warehouse::with('address')->where('owner', Auth::id())->get();
            $cartItems = Cart::with('sku.product')->where('created_by', Auth::id())->get();
        } else {
            $cartItems = Cart::with('shop', 'product.shopProduct')->where('created_by', Auth::id())->get();
        }
        if (count($cartItems) > 0) {
            foreach ($cartItems as $cartItem) {
                $cartItem->update([
                    'expected_delivery_date' => Carbon::today()->addDays(rand(0, 8)),
                ]);
            }

            return view('order.checkout', compact('cartItems', 'addresses'));
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
        $cart = Cart::with('sku.product')->where('created_by', Auth::id())->get();
        if (isset($validatedData['address'])) {
            $shopAddress = ShopAddress::with('warehouse')->find($validatedData['address']);
        }
        foreach ($cart as $value) {
            Order::create([
                'expected_delivery_date' => $value['expected_delivery_date'],
                'payment_type' => $validatedData['payment_type'],
                'qty' => $value['qty'],
                'total_amount' => $value['qty'] * $value->sku->price,
                'shop_id' => $value['shop_id'],
                'sku_id' => $value['sku_id'],
                'warehouse_id' => isset($shopAddress) && isset($shopAddress->warehouse) ? $shopAddress->warehouse->id : null,
                'order_by' => Auth::id(),
                'status' => 1,
            ]);
        }

        $message = 'Order placed successfully';

        return redirect()->route('orders.index')->with('alert-success', $message);
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
                'cancelled_reason' => $request->input('reason'),
            ]);

            if ($request->file('cancelled_reason_image')) {
                $name = preg_replace('/\s+/', '', $orderDetails->id).'_'.time();
                $folder = '/cancel-orders/'.$orderDetails->id.'/';
                Helper::uploadOne($request->file('cancelled_reason_image'), $folder, 'public', $name);

                $filePath = $folder.$name.'.'.$request->file('cancelled_reason_image')->clientExtension();
                Order::find($id)->update(['cancelled_reason_image' => $filePath]);
            }

            return response()->json(['message' => 'record deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'order not found'], 400);
        }
    }
}
