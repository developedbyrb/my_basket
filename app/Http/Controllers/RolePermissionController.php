<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function showMatrix()
    {
        $roles = Role::where('id', '<>', 1)->get();
        $permissions = Permission::get();
        return view('matrix.index', compact('roles', 'permissions'));
    }
}
