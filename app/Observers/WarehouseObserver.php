<?php

namespace App\Observers;

use App\Models\ShopAddress;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseObserver
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the Warehouse "created" event.
     */
    public function created(Warehouse $warehouse): void
    {
        // Create Warehouse Addresses
        foreach ($this->request->input('addresses') as $key => $address) {
            ShopAddress::create([
                'warehouse_id' => $warehouse->id,
                'house_no' => $address['house_no'],
                'area' => $address['area'],
                'city' => $address['city'],
                'pincode' => $address['pincode'],
                'state' => $address['state'],
                'country' => $address['country'],
                'alias' => $address['alias'],
                'is_default' => (count($this->request->input('addresses')) === 1 || $key === 1) ? 1 : 0,
            ]);
        }
    }

    /**
     * Handle the Warehouse "updated" event.
     */
    public function updated(Warehouse $warehouse): void
    {
        //
    }

    /**
     * Handle the Warehouse "deleted" event.
     */
    public function deleted(Warehouse $warehouse): void
    {
        //
    }

    /**
     * Handle the Warehouse "restored" event.
     */
    public function restored(Warehouse $warehouse): void
    {
        //
    }

    /**
     * Handle the Warehouse "force deleted" event.
     */
    public function forceDeleted(Warehouse $warehouse): void
    {
        //
    }
}
