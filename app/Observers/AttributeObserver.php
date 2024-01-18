<?php

namespace App\Observers;

use App\Models\Attribute;
use App\Models\AttributeOption;
use Illuminate\Http\Request;

class AttributeObserver
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the Attribute "created" event.
     */
    public function created(Attribute $attribute): void
    {
        // Insert records for attribute options
        $options = $this->request->input('options');
        foreach ($options as $option) {
            AttributeOption::create([
                'attribute_id' => $attribute->id,
                'value' => $option['value'],
            ]);
        }

        // Attaching categories to attributes
        $categories = $this->request->input('categories');
        $attribute->categories()->attach($categories);
    }

    /**
     * Handle the Attribute "updated" event.
     */
    public function updated(Attribute $attribute): void
    {
        //
    }

    /**
     * Handle the Attribute "deleted" event.
     */
    public function deleted(Attribute $attribute): void
    {
        $attribute->attributeOptions()->delete();
    }

    /**
     * Handle the Attribute "restored" event.
     */
    public function restored(Attribute $attribute): void
    {
        //
    }

    /**
     * Handle the Attribute "force deleted" event.
     */
    public function forceDeleted(Attribute $attribute): void
    {
        //
    }
}
