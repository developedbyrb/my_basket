<?php

namespace App\Observers;

use App\Models\AttributeOptionSku;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductTag;
use App\Models\Sku;
use App\Traits\GenerateSkus;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;

class ProductObserver
{
    protected $request;
    use GenerateSkus;
    use ImageUpload;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product): void
    {
        $requestData = $this->request;

        // Create product Details
        ProductDetail::create([
            'product_id' => $product->id,
            'brand' => $requestData->input('brand'),
            'price' => $requestData->input('price'),
            'weight' => $requestData->input('weight'),
            'return_policy' => $requestData->input('return_policy'),
            'length' => $requestData->input('length'),
            'width' => $requestData->input('width'),
            'breadth' => $requestData->input('breadth'),
            'ships_from' => $requestData->input('ships_from'),
            'ship_by' => $requestData->input('sold_by'),
            'import_fees' => $requestData->input('import_fees'),
            'state' => $requestData->input('product_state')
        ]);

        //store product tags
        $tagArray = explode(',', $requestData->input('tags'));
        foreach ($tagArray as $tag) {
            ProductTag::create([
                'product_id' => $product->id,
                'value' => $tag
            ]);
        }

        $product->categories()->attach($this->request->input('categories'));

        // Create Product SKU
        foreach ($requestData->input('variants') as $skuData) {
            $newSku = Sku::create([
                'product_id' => $product->id,
                'code' => $this->generate($product->name, $product->id, $requestData->input('brand'), $skuData),
                'price' => $skuData['price'],
                'avail_stock' => $skuData['avail_stock'],
                'is_default' => isset($skuData['is_default']) ? 1 : 0
            ]);

            // upload product image
            $uploadedImage = '/' . $this->upload($this->request, 'image', 'skus', $product);
            Sku::find($newSku->id)->update(['image' => $uploadedImage]);

            unset($skuData["price"]);
            unset($skuData["is_default"]);
            unset($skuData["avail_stock"]);
            foreach ($skuData as $value) {
                // Create Attribute Options
                AttributeOptionSku::create([
                    'sku_id' => $newSku->id,
                    'attribute_option_id' => $value
                ]);
            }
        }
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "deleted" event.
     */
    public function deleted(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     */
    public function restored(Product $product): void
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     */
    public function forceDeleted(Product $product): void
    {
        //
    }
}
