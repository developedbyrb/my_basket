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
            $returnHTML = view('category.partials.tableRows')->with('categories', $categories)->render();
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
}
