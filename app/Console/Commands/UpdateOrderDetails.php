<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\WarehouseProduct;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateOrderDetails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-order-details';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orders = Order::where('status', '<>', '4')->whereDate('expected_delivery_date', '<', Carbon::today())->get();
        foreach ($orders as $order) {
            $order->update([
                'status' => 3,
            ]);

            // update warehouse product stock
            WarehouseProduct::create([
                'warehouse_id' => $order->warehouse_id,
                'sku_id' => $order->sku_id,
                'available_stock' => $order->qty,
            ]);
        }
    }
}
