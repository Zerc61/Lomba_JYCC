<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = User::latest()->paginate(10);

        return [
            "status" => 1,
            "data" => $user
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3|max:20',
            'name' => 'required|string|max:30',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return [
            "status" => 1,
            "data" => $user
        ];
    }

    public function show(User $user)
    {
        return [
            "status" => 1,
            "data" => $user
        ];
    }

    public function update(Request $request, User $user)
{
    $request->validate([
        'username' => 'required|string|max:20|unique:users,username,' . $user->id_user . ',id_user',
        'name' => 'required|string|max:30',
        'email' => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
        'password' => 'nullable|min:6'
    ]);

    $user->username = $request->username;
    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->password) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return [
        "status" => 1,
        "data" => $user,
        "msg" => "User updated successfully"
    ];
}


    public function destroy(User $user)
    {
        $user->delete();

        return [
            "status" => 1,
            "data" => $user,
            "msg" => "User deleted successfully"
        ];
    }


        public function patch(Request $request, User $user)
    {
        // Rules dinamis berdasarkan field yang dikirim
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

        // Validasi field yang dikirim
        $request->validate($rules);

        // Update field yang dikirim saja
        foreach ($request->only(array_keys($rules)) as $key => $value) {
            if ($key === 'password') {
                $user->password = Hash::make($value);
            } else {
                $user->$key = $value;
            }
        }

        // Simpan perubahan
        $user->save();

        return [
            "status" => 1,
            "data" => $user,
            "msg" => "User partially updated successfully"
        ];
    }
}
