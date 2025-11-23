<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Topup;

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
            'id_user' => 'required|numeric',
            'name' => 'required|max:20',
            'email' => 'required|email',
            'no_telpon' => 'required|max:20',
            'role' => 'required|in:admin,user,umkm,driver',
            'saldo_rupiah' => 'nullable|numeric',
            'saldo_emas' => 'nullable|numeric',
            'saldo_dcoin' => 'nullable|numeric',
            'pajak' => 'required',
            'admin' => 'required',
            'metode_pembayaran' => 'required',
        ]);

        try {
            $topup = Topup::create([
                'id_user' => $request->id_user,
                'name' => $request->name,
                'email' => $request->email,
                'no_telpon' => $request->no_telpon,
                'role' => $request->role,
                'saldo_rupiah' => $request->saldo_rupiah ?? 0,
                'saldo_emas' => $request->saldo_emas ?? 0,
                'saldo_dcoin' => $request->saldo_dcoin ?? 0,
                'pajak' => $request->pajak,
                'admin' => $request->admin,
                'metode_pembayaran' => $request->metode_pembayaran,
            ]);

            return [
                "status" => 1,
                "data" => $topup,
                "msg" => "Topup created successfully"
            ];

        } catch (\Exception $e) {

            return [
                "status" => 0,
                "msg" => "Insert error: " . $e->getMessage()
            ];
        }
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
        'id_user' => 'required|numeric',
        'name' => 'required|max:20',
        'role' => 'required|in:admin,user,umkm,driver',
        'saldo_dcoin' => 'nullable|numeric',
        'pajak' => 'required',
        'admin' => 'required',
        'metode_pembayaran' => 'required',
        'status_bayar' => 'required|in:sudah,belum', // tambahkan validasi ini
    ]);

    $topup->update([
        'id_user' => $request->id_user,
        'name' => $request->name,
        'email' => $request->email,
        'no_telpon' => $request->no_telpon,
        'role' => $request->role,
        'saldo_rupiah' => $request->saldo_rupiah,
        'saldo_emas' => $request->saldo_emas,
        'saldo_dcoin' => $request->saldo_dcoin,
        'pajak' => $request->pajak,
        'admin' => $request->admin,
        'metode_pembayaran' => $request->metode_pembayaran,
        'status_bayar' => $request->status_bayar, // WAJIB ADA
    ]);

    return [
        "status" => 1,
        "data" => $topup,
        "msg" => "Topup updated successfully"
    ];
}


    public function destroy(Topup $topup)
    {
        $topup->delete();

        return [
            "status" => 1,
            "data" => $topup,
            "msg" => "Topup deleted successfully"
        ];
    }
}