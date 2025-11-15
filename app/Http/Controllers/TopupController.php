<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topup;
use Illuminate\Support\Facades\Hash;

class TopupController extends Controller
{
    public function index()
    {
        $topup = Topup::latest()->paginate(10);

        return [
            "status" => 1,
            "data" => $topup
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:20',
            'email' => 'required|email|unique:topups,email',
            'password' => 'required|min:6',
            'no_telpon' => 'required|max:20|unique:topups,no_telpon',
            'role' => 'in:admin,user,umkm,driver',
            'saldo_rupiah' => 'numeric',
            'saldo_emas' => 'numeric',
            'saldo_dcoin' => 'numeric',
        ]);

        $topup = Topup::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_telpon' => $request->no_telpon,
            'role' => $request->role ?? 'user',
            'saldo_rupiah' => $request->saldo_rupiah ?? 0,
            'saldo_emas' => $request->saldo_emas ?? 0,
            'saldo_dcoin' => $request->saldo_dcoin ?? 0,
        ]);

        return [
            "status" => 1,
            "data" => $topup,
            "msg" => "topup created successfully"
        ];
    }

    public function show(Topup $topup)
    {
        return [
            "status" => 1,
            "data" => $topup
        ];
    }

    public function update(Request $request, Topup $topup)
    {
        $request->validate([
            'name' => 'required|max:20',
            'email' => 'required|email|unique:topups,email,' . $topup->id_topup . ',id_topup',
            'password' => 'nullable|min:6',
            'no_telpon' => 'required|max:20|unique:topups,no_telpon,' . $topup->id_topup . ',id_topup',
            'role' => 'in:admin,user,umkm,driver',
            'saldo_rupiah' => 'numeric',
            'saldo_emas' => 'numeric',
            'saldo_dcoin' => 'numeric',
        ]);

        $topup->name = $request->name;
        $topup->email = $request->email;
        $topup->no_telpon = $request->no_telpon;
        $topup->role = $request->role;

        if ($request->password) {
            $topup->password = Hash::make($request->password);
        }

        if ($request->saldo_rupiah !== null) $topup->saldo_rupiah = $request->saldo_rupiah;
        if ($request->saldo_emas !== null) $topup->saldo_emas = $request->saldo_emas;
        if ($request->saldo_dcoin !== null) $topup->saldo_dcoin = $request->saldo_dcoin;

        $topup->save();

        return [
            "status" => 1,
            "data" => $topup,
            "msg" => "topup updated successfully"
        ];
    }

    public function patch(Request $request, Topup $topup)
    {
        $rules = [];

        if ($request->has('name')) {
            $rules['name'] = 'max:20';
        }

        if ($request->has('email')) {
            $rules['email'] = 'email|unique:topups,email,' 
                . $topup->id_topup . ',id_topup';
        }

        if ($request->has('password')) {
            $rules['password'] = 'min:6';
        }

        if ($request->has('no_telpon')) {
            $rules['no_telpon'] = 'max:20|unique:topups,no_telpon,' 
                . $topup->id_topup . ',id_topup';
        }

        if ($request->has('role')) {
            $rules['role'] = 'in:admin,user,umkm,driver';
        }

        if ($request->has('saldo_rupiah')) $rules['saldo_rupiah'] = 'numeric';
        if ($request->has('saldo_emas')) $rules['saldo_emas'] = 'numeric';
        if ($request->has('saldo_dcoin')) $rules['saldo_dcoin'] = 'numeric';

        $request->validate($rules);

        foreach ($request->only(array_keys($rules)) as $key => $value) {
            if ($key === 'password') {
                $topup->password = Hash::make($value);
            } else {
                $topup->$key = $value;
            }
        }

        $topup->save();

        return [
            "status" => 1,
            "data" => $topup,
            "msg" => "topup partially updated successfully"
        ];
    }

    public function destroy(Topup $topup)
    {
        $topup->delete();

        return [
            "status" => 1,
            "data" => $topup,
            "msg" => "topup deleted successfully"
        ];
    }
}
