<?php

namespace App\Observers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ShopAddress;
use App\Models\ShopProduct;
use App\Models\Sku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderObserver
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        $shopAddress = ShopAddress::find($this->request->address);

        // create order details
        OrderDetail::create([
            'order_id' => $order->id,
            'house_no' => isset($shopAddress) ? $shopAddress->house_no : $this->request->house_no,
            'area' => isset($shopAddress) ? $shopAddress->area : $this->request->area,
            'city' => isset($shopAddress) ? $shopAddress->city : $this->request->city,
            'pincode' => isset($shopAddress) ? $shopAddress->pincode : $this->request->pincode,
            'state' => isset($shopAddress) ? $shopAddress->state : $this->request->state,
            'country' => isset($shopAddress) ? $shopAddress->country : $this->request->country,
        ]);

        // remove items from cart
        Cart::where('created_by', Auth::id())->delete();

        // update product stock
        if (Auth::user()->role->id == 3) {
            $sku = Sku::find($order->sku_id);
            $sku->avail_stock = $sku->avail_stock - $order->qty;
            $sku->save();
        } else {
            $shopProduct = ShopProduct::where('sku_id', $order->sku_id)->first();
            $shopProduct->stock_qty = $shopProduct->stock_qty - $order->qty;
            $shopProduct->save();
        }
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
