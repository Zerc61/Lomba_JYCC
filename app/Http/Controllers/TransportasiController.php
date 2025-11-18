<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transportasi;

class TransportasiController extends Controller
{
    public function index()
    {
        $data = Transportasi::latest()->paginate(10);

        return [
            "status" => 1,
            "data" => $data
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'informasi_transportasi' => 'required|string|max:100',
            'jenis_kendaraan' => 'required|string|max:50',
            'nama_driver' => 'required|string|max:50',
            'plat_nomor' => 'required|string|max:20',
            'harga' => 'required',
            'diskon' => 'nullable',
            'informasi_online' => 'nullable',
            'deskripsi_transportasi' => 'nullable'
        ]);

        $data = Transportasi::create($request->all());

        return [
            "status" => 1,
            "data" => $data
        ];
    }

    public function show(Transportasi $transportasi)
    {
        return [
            "status" => 1,
            "data" => $transportasi
        ];
    }

    public function update(Request $request, Transportasi $transportasi)
    {
        $request->validate([
            'informasi_transportasi' => 'required|string|max:100',
            'jenis_kendaraan' => 'required|string|max:50',
            'nama_driver' => 'required|string|max:50',
            'plat_nomor' => 'required|string|max:20',
            'harga' => 'required',
        ]);

        $transportasi->update($request->all());

        return [
            "status" => 1,
            "data" => $transportasi,
            "msg" => "Transportasi updated successfully"
        ];
    }

    public function patch(Request $request, Transportasi $transportasi)
    {
        $transportasi->update($request->all());

        return [
            "status" => 1,
            "data" => $transportasi,
            "msg" => "Transportasi partially updated successfully"
        ];
    }

    public function destroy(Transportasi $transportasi)
    {
        $transportasi->delete();

        return [
            "status" => 1,
            "msg" => "Transportasi deleted successfully"
        ];
    }
}
