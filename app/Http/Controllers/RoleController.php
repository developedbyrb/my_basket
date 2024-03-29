<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse|View
    {
        $roles = Role::orderBy('id', 'asc')->get();
        if ($request->ajax()) {
            $page = 'roles';
            $returnHTML = view('layouts.common.tables.tableRows')->with('rowData', $roles)
                ->with('page', $page)->render();
            $response = [
                'success' => true,
                'data' => [
                    'html' => $returnHTML,
                ],
                'message' => 'Roles list fetched successfully.',
            ];

            return response()->json($response);
        }

        return view('role.index', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
        ]);

        Role::create([
            'name' => $request->input('name'),
        ]);

        return response()->json(['message' => 'Role created Successfully', 'success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response(Role::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Role::findOrFail($id)) {
            $data = [
                'role' => Role::findOrFail($id),
            ];

            return response(['success' => true, 'data' => $data, 'message' => 'Role data found successfully.']);
        } else {
            return response(['success' => false, 'data' => [], 'message' => 'Role not found.']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $role = Role::find($id);
        if ($role) {
            $request->validate([
                'name' => 'required|string|unique:roles,name,'.$id,
            ]);

            $role->update([
                'name' => $request->input('name'),
            ]);

            return response(['message' => 'Role Updated Successfully', 'success' => true]);
        } else {
            return response(['message' => 'Role not found', 'success' => false], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $role = Role::find($id);
        if (! $role) {
            return response()->json(['message' => 'Role not found.'], 404);
        }
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully.']);
    }
}
