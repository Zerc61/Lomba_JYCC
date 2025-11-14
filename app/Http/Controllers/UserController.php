<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::latest()->paginate(10);

        return [
            "status" => 1,
            "data" => $user
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|max:20',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            "status" => 1,
            "data" => $user,
            "token" => $token,
            "token_type" => "bearer"
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return [
            "status" => 1,
            "data" => $user
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
           'username' => 'required|max:20',
           'name' =>'required',
           'email' => 'required|email|unique|users,emaii,' .$user->id,
           'password' => 'nullable|min:6',
        ]);

        $user->username = $request->username;
        $user->name = $request->name;
        $user->email = $request->email;

        if($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user -> save();

        return [
            "status" => 1,
            "data" => $user,
            "msg" => "user update succesfully"
        ];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user -> delete();
        return [
            "status" => 1,
            "data" => $user,
            "msg" => "user delete success"
        ];
    }
}
