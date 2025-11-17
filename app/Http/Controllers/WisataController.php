<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wisata;

class WisataController extends Controller
{
    public function index() {
        $wisata = Wisata::latest()->paginate(10);

        return response()->json([
            'status' => 1,
            'data' => $wisata
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'nama_wisata' => 'required',
            'alamat_wisata' => 'required',
            'informasi_wisata' => 'required',
            'biaya_wisata' => 'required|numeric',
            'kategori' => 'required',
            'lokasi' => 'required',
            'foto_wisata' => 'nullable|image|max:2048'
        ]);

        $foto = null;

        if($request->hasFile('foto_wisata')){
            $foto = file_get_contents($request->file('foto_wisata'));
        }

        $wisata = Wisata::create([
        'nama_wisata' => $request->nama_wisata,
        'alamat_wisata' => $request->alamat_wisata,
        'informasi_wisata' => $request->informasi_wisata,
        'biaya_wisata' => $request->biaya_wisata,
        'kategori' => $request->kategori,
        'lokasi' => $request->lokasi,
        'foto_wisata' => $foto
            
        ]);

    return response()->json([
        'status' => true,
        'message' => 'Data wisata berhasil ditambahkan',
        'data' => $wisata
       ]);
    }
}
