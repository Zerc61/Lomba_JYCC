<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    public function index()
    {
        $data = Transaksi::latest()->paginate(10);

        return [
            "status" => 1,
            "data" => $data
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_transportasi' => 'required|integer',
            'id_user' => 'required|integer',
            'id_paket' => 'required|integer',
            'harga' => 'required|string|max:30',
            'jam_berangkat' => 'required',
            'jam_tiba' => 'required',
            'tanggal_berangkat' => 'required|date',
            'tanggal_tiba' => 'required|date',
            'tujuan' => 'required|string|max:100',
            'status' => 'required|string|max:20'
        ]);

        $data = Transaksi::create($request->all());

        return [
            "status" => 1,
            "data" => $data
        ];
    }

    public function show(Transaksi $transaksi)
    {
        return [
            "status" => 1,
            "data" => $transaksi
        ];
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'id_transportasi' => 'required|integer',
            'id_user' => 'required|integer',
            'id_paket' => 'required|integer',
            'harga' => 'required|string|max:30',
            'jam_berangkat' => 'required',
            'jam_tiba' => 'required',
            'tanggal_berangkat' => 'required|date',
            'tanggal_tiba' => 'required|date',
            'tujuan' => 'required|string|max:100',
            'status' => 'required|string|max:20',
        ]);

        $transaksi->update($request->all());

        return [
            "status" => 1,
            "data" => $transaksi,
            "msg" => "Transaksi updated successfully"
        ];
    }

    public function patch(Request $request, Transaksi $transaksi)
    {
        $transaksi->update($request->all());

        return [
            "status" => 1,
            "data" => $transaksi,
            "msg" => "Transaksi partially updated successfully"
        ];
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        return [
            "status" => 1,
            "msg" => "Transaksi deleted successfully"
        ];
    }
}
