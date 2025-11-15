<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topup;
use Illuminate\Support\Facades\Hash;

class TopupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $topup = Topup::latest()->paginate(10);

        return [
            "status" => 1,
            "data" => $topup
        ];
    }

    /**
     * Store a newly created resource in storage.
     */
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
            'password' => Hash::make($request->password),   // HASH PASSWORD
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

    /**
     * Display the specified resource.
     */
    public function show(Topup $topup)
    {
        return [
            "status" => 1,
            "data" => $topup
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Topup $topup)
    {
        $request->validate([
            'name' => 'required|max:20',
            'email' => 'required|email|unique:topups,email,' . $topup->id,
            'password' => 'nullable|min:6',
            'no_telpon' => 'required|max:20|unique:topups,no_telpon,' . $topup->id,
            'role' => 'in:admin,user,umkm,driver',
            'saldo_rupiah' => 'numeric',
            'saldo_emas' => 'numeric',
            'saldo_dcoin' => 'numeric',
        ]);

        $topup->name = $request->name;
        $topup->email = $request->email;
        $topup->no_telpon = $request->no_telpon;
        $topup->role = $request->role;

        // JIKA PASSWORD DIUPDATE, HASH ULANG
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

    /**
     * Remove the specified resource from storage.
     */
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
