<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::latest()->get();
        if ($request->ajax()) {
            $returnHTML = view('user.partials.tableRows')->with('users', $users)->render();
            $response = [
                'success' => true,
                'data' => [
                    'html' => $returnHTML
                ],
                'message' => 'Users list fetched successfully.'
            ];
            return response($response);
        }
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::select('id', 'name')->get();

        $responseData = [
            'success' => true,
            'data' => ['roles' => $roles],
            'message' => ''
        ];
        return response($responseData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users',
            'role_id' => 'required',
            'profile_pic' => 'mimes:png,jpg,jpeg|max:2048',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role_id' => $request->input('role_id'),
            'password' => ''
        ]);

        event(new Registered($user));

        if ($request->file('profile_pic')) {
            $name = preg_replace('/\s+/', '', $user->name) . '_' . time();
            $folder = '/users/' . $user->id . '/';
            Helper::uploadOne($request->file('profile_pic'), $folder, 'public', $name);

            $filePath = $folder . $name . '.' . $request->file('profile_pic')->clientExtension();
            User::find($user->id)->update(['profile_pic' => $filePath]);
        }

        return response(['message' => 'User Created Successfully', 'success' => true]);
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
        if (User::findOrFail($id)) {
            $data = [
                'user' => User::findOrFail($id),
                'roles' => Role::select('id', 'name')->get()
            ];
            return response(['success' => true, 'data' => $data, 'message' => 'User data found successfully.']);
        } else {
            return response(['success' => false, 'data' => [], 'message' => 'User not found.']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        if ($user) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'role_id' => 'required',
                'profile_pic' => 'mimes:png,jpg,jpeg|max:2048',
            ]);

            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'role_id' => $request->input('role_id')
            ]);


            if ($request->file('profile_pic')) {
                $name = preg_replace('/\s+/', '', $user->name) . '_' . time();
                $folder = '/users/' . $user->id . '/';
                Helper::uploadOne($request->file('profile_pic'), $folder, 'public', $name);

                $filePath = $folder . $name . '.' . $request->file('profile_pic')->clientExtension();
                User::find($user->id)->update(['profile_pic' => $filePath]);
            }

            return response(['message' => 'User Updated Successfully', 'success' => true]);
        } else {
            return response(['message' => 'User not found', 'success' => false], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }
        $user->delete();
        return response()->json(['message' => 'User deleted successfully.']);
    }
}
