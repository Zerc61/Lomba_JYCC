<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paket;

class PaketController extends Controller
{
    public function index()
    {
        $data = Paket::latest()->paginate(10);

        return [
            "status" => 1,
            "data" => $data
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_umkm' => 'required|integer',
            'jenis_paket' => 'required|string|max:50',
            'deskripsi_paket' => 'nullable|string'
        ]);

        $data = Paket::create($request->all());

        return [
            "status" => 1,
            "data" => $data
        ];
    }

    public function show(Paket $paket)
    {
        return [
            "status" => 1,
            "data" => $paket
        ];
    }

    public function update(Request $request, Paket $paket)
    {
        $request->validate([
            'id_umkm' => 'required|integer',
            'jenis_paket' => 'required|string|max:50',
            'deskripsi_paket' => 'nullable|string'
        ]);

        $paket->update($request->all());

        return [
            "status" => 1,
            "data" => $paket,
            "msg" => "Paket updated successfully"
        ];
    }

    public function patch(Request $request, Paket $paket)
    {
        $paket->update($request->all());

        return [
            "status" => 1,
            "data" => $paket,
            "msg" => "Paket partially updated successfully"
        ];
    }

    public function destroy(Paket $paket)
    {
        $paket->delete();

        return [
            "status" => 1,
            "msg" => "Paket deleted successfully"
        ];
    }
}
