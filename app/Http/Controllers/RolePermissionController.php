<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::where('id', '<>', 1)->with('permissions')->get();
        $permissions = Permission::get();
        return view('matrix.index', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        RolePermission::truncate();
        $updatePermissions = $request->permissions;
        foreach ($updatePermissions as $role => $permissions) {
            foreach ($permissions as $permission) {
                RolePermission::create([
                    'role_id' => $role,
                    'permission_id' => $permission
                ]);
            }
        }

        return redirect('/access-management');
    }
}
