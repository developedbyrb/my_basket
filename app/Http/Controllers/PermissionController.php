<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permissions = Permission::get();
        if ($request->ajax()) {
            $returnHTML = view('permission.partials.tableRows')->with('permissions', $permissions)->render();
            $response = [
                'success' => true,
                'data' => [
                    'html' => $returnHTML
                ],
                'message' => 'Permissions list fetched successfully.'
            ];
            return response($response);
        }
        return view('permission.index', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions'
        ]);

        Permission::create(['name' => $request->input('name')]);

        return response()->json([
            'success' => true,
            'message' => 'Permission created Successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Permission::findOrFail($id)) {
            $data = [
                'permission' => Permission::findOrFail($id)
            ];
            return response(['success' => true, 'data' => $data, 'message' => 'Permission data found successfully.']);
        } else {
            return response(['success' => false, 'data' => [], 'message' => 'Permission not found.']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $permission = Permission::find($id);
        if ($permission) {
            $request->validate([
                'name' => 'required|string|unique:permissions,name,' . $id
            ]);

            $permission->update([
                'name' => $request->input('name')
            ]);

            return response(['message' => 'Permission Updated Successfully', 'success' => true]);
        } else {
            return response(['message' => 'Permission not found', 'success' => false], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $permission = Permission::find($id);
        if (!$permission) {
            return response()->json(['message' => 'Permission not found.'], 404);
        }
        $permission->delete();
        return response()->json(['message' => 'Permission deleted successfully.']);
    }
}
