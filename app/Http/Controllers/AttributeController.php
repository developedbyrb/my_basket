<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|View
    {
        $attributes = Attribute::with('attributeOptions', 'categories')->get();

        return view('attribute.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();

        return view('attribute.sections.upsert-attribute', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:attributes',
            'categories' => 'required',
            'options.*.value' => 'required',
        ]);

        Attribute::create([
            'name' => $request->input('name'),
        ]);

        $message = 'Product attribute created successfully.';

        return redirect()->route('attributes.index')->with('alert-success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        return response()->json(Attribute::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $attributeDetails = Attribute::with('attributeOptions', 'categories')->findOrFail($id);
        $categories = Category::get();

        return view('attribute.sections.upsert-attribute', compact('attributeDetails', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $attribute = Attribute::find($id);
        if ($attribute) {
            $request->validate([
                'name' => 'required|string|unique:attributes,name,'.$id,
            ]);

            $attribute->update([
                'name' => $request->input('name'),
            ]);

            $message = 'Attribute updated successfully.';

            return redirect()->route('attributes.index')->with('alert-success', $message);
        } else {
            $message = 'Attribute not found.';

            return redirect()->back()->with('alert-error', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $attribute = Attribute::find($id);
        if (! $attribute) {
            return response()->json(['message' => 'Attribute not found.'], 404);
        }
        $attribute->delete();

        return response()->json(['message' => 'Attribute deleted successfully.']);
    }
}
