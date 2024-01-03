<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response | View
    {
        $categories = Category::latest()->get();
        if ($request->ajax()) {
            $page = 'categories';
            $returnHTML = view('layouts.common.tables.tableRows')->with('rowData', $categories)
                ->with('page', $page)->render();
            $response = [
                'success' => true,
                'data' => [
                    'html' => $returnHTML
                ],
                'message' => 'Category list fetched successfully.'
            ];
            return response($response);
        }
        return view('category.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories'
        ]);

        Category::create([
            'name' => $request->input('name')
        ]);

        return response(['message' => 'Category created Successfully', 'success' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): Response
    {
        if (Category::findOrFail($id)) {
            $data = [
                'category' => Category::findOrFail($id)
            ];
            return response(['success' => true, 'data' => $data, 'message' => 'Category data found successfully.']);
        } else {
            return response(['success' => false, 'data' => [], 'message' => 'Category not found.']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): Response
    {
        $category = Category::find($id);
        if ($category) {
            $request->validate([
                'name' => 'required|string|unique:categories,name,' . $id
            ]);

            $category->update([
                'name' => $request->input('name')
            ]);

            return response(['message' => 'Category Updated Successfully', 'success' => true]);
        } else {
            return response(['message' => 'Category not found', 'success' => false], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $category = Category::find($id);
        if (!$category) {
            return response()->json(['message' => 'Category not found.'], 404);
        }
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully.']);
    }

    /**
     * return html for a listing of the variants.
     */
    public function categoryAttributes(Request $request)
    {
        $count = $request->input('variantCount');
        $variants = Category::with('attributes.attributeOptions')
            ->findMany($request->input('categories'))
            ->pluck('attributes')
            ->flatten()
            ->unique('id');
        if (count($variants) > 0 && $count > 0) {
            $returnHTML = view('product.partials.addVariants')->with('variants', $variants)
                ->with('variantCount', $count)
                ->render();
            $response = [
                'success' => true,
                'data' => [
                    'html' => $returnHTML
                ],
                'message' => 'Product attributes list fetched successfully.'
            ];
            return response()->json($response);
        } else {
            return redirect()->back();
        }
    }
}
