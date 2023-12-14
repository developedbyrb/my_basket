<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role_id === 1) {
            $roles = Role::get();
        } else {
            $roles = Role::where('name', '<>', 'Admin')->get();
        }
        return view('role.index', compact("roles"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);
        if (!$role) {
            return response()->json(['message' => 'Role not found.'], 404);
        }
        $role->delete();
        return response()->json(['message' => 'Role deleted successfully.']);
    }

    /**
     * Create Or Update Role
     */
    public function upSert(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $category = Role::updateOrCreate([
            'name' => $request->input('name')
        ]);
        return response()->json([
            'success' => true,
            'data' => $category,
            'message' => 'Created Successfully.'
        ]);
    }
}
