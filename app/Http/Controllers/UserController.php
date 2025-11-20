<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ============================
    // GET ALL USERS (PAGINATED)
    // ============================
    public function index()
    {
        $users = User::latest()->paginate(10);

        return response()->json([
            "status" => 1,
            "total"  => $users->total(),
            "data"   => $users->items(),
            "paging" => [
                "current_page" => $users->currentPage(),
                "per_page"     => $users->perPage(),
                "last_page"    => $users->lastPage()
            ]
        ]);
    }

    // ============================
    // STORE USER
    // ============================
    public function store(Request $request)
    {
        $request->validate([
            'username'   => 'required|string|min:3|max:20',
            'name'       => 'required|string|max:30',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:6',
            'no_telpon'  => 'nullable|max:15', // tambahkan ini
            'role'       => 'required|in:admin,user,umkm,driver'
        ]);

        $user = User::create([
            'username'   => $request->username,
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'no_telpon'  => $request->no_telpon, // simpan nomor telepon
            'role'       => $request->role
        ]);

        return response()->json([
            "status" => 1,
            "data"   => $user
        ]);
    }

    // ============================
    // SHOW USER
    // ============================
    public function show(User $user)
    {
        return response()->json([
            "status" => 1,
            "data"   => $user
        ]);
    }

    // ============================
    // UPDATE USER (PUT)
    // ============================
    public function update(Request $request, User $user)
    {
        $request->validate([
            'username'   => 'required|string|max:20|unique:users,username,' . $user->id_user . ',id_user',
            'name'       => 'required|string|max:30',
            'email'      => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'password'   => 'nullable|min:6',
            'no_telpon'  => 'nullable|max:15',
            'role'       => 'required|in:admin,user,umkm,driver'
        ]);

        $user->username   = $request->username;
        $user->name       = $request->name;
        $user->email      = $request->email;
        $user->no_telpon  = $request->no_telpon;
        $user->role       = $request->role;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return response()->json([
            "status" => 1,
            "data"   => $user,
            "msg"    => "User updated successfully"
        ]);
    }

    // ============================
    // DELETE USER
    // ============================
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            "status" => 1,
            "msg"    => "User deleted successfully"
        ]);
    }

    // ============================
    // PATCH USER (PARTIAL UPDATE)
    // ============================
    public function patch(Request $request, User $user)
    {
        $rules = [];

        if ($request->has('username')) {
            $rules['username'] = 'string|min:3|max:20|unique:users,username,' . $user->id_user . ',id_user';
        }
        if ($request->has('name')) {
            $rules['name'] = 'string|max:30';
        }
        if ($request->has('email')) {
            $rules['email'] = 'email|unique:users,email,' . $user->id_user . ',id_user';
        }
        if ($request->has('password')) {
            $rules['password'] = 'min:6';
        }
        if ($request->has('no_telpon')) {
            $rules['no_telpon'] = 'max:15';
        }
        if ($request->has('role')) {
            $rules['role'] = 'in:admin,user,umkm,driver';
        }

        $request->validate($rules);

        foreach ($request->only(array_keys($rules)) as $key => $value) {
            if ($key === 'password') {
                $user->password = Hash::make($value);
            } else {
                $user->$key = $value;
            }
        }

        $user->save();

        return response()->json([
            "status" => 1,
            "data"   => $user,
            "msg"    => "User partially updated successfully"
        ]);
    }
}
