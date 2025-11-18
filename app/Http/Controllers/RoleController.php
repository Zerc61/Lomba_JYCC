<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return [
            "status" => 1,
            "data" => Role::latest()->paginate(10)
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_role' => 'required|string|max:30',
            'deskripsi' => 'nullable|string'
        ]);

        $data = Role::create($request->all());

        return [
            "status" => 1,
            "data" => $data
        ];
    }

    public function show(Role $role)
    {
        return [
            "status" => 1,
            "data" => $role
        ];
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'nama_role' => 'required|string|max:30',
            'deskripsi' => 'nullable|string'
        ]);

        $role->update($request->all());

        return [
            "status" => 1,
            "data" => $role,
            "msg" => "Role updated successfully"
        ];
    }

    public function patch(Request $request, Role $role)
    {
        $role->update($request->all());

        return [
            "status" => 1,
            "data" => $role,
            "msg" => "Role partially updated successfully"
        ];
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return [
            "status" => 1,
            "msg" => "Role deleted successfully"
        ];
    }
}
