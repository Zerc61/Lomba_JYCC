<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wisata;
use Illuminate\Support\Facades\Storage;

class WisataController extends Controller
{
    public function index()
    {
        $wisata = Wisata::latest()->paginate(10);

        return response()->json([
            'status' => 1,
            'data' => $wisata
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_wisata' => 'required|string|max:255',
            'alamat_wisata' => 'required|string',
            'informasi_wisata' => 'required|string',
            'biaya_wisata' => 'required|numeric',
            'kategori' => 'required|string|max:50',
            'lokasi' => 'required|string',
            'foto_wisata' => 'nullable|image|max:2048'
        ]);

        $foto = $request->hasFile('foto_wisata')
            ? $request->file('foto_wisata')->store('wisata', 'public')
            : null;

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

    public function show(Wisata $wisata)
    {
        return response()->json([
            'status' => 1,
            'data' => $wisata
        ]);
    }

    public function update(Request $request, Wisata $wisata)
    {
        $request->validate([
            'nama_wisata' => 'required|string|max:255',
            'alamat_wisata' => 'required|string',
            'informasi_wisata' => 'required|string',
            'biaya_wisata' => 'required|numeric',
            'kategori' => 'required|string|max:50',
            'lokasi' => 'required|string',
            'foto_wisata' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('foto_wisata')) {
            $wisata->foto_wisata = $request->file('foto_wisata')->store('wisata', 'public');
        }

        $wisata->update($request->only([
            'nama_wisata', 'alamat_wisata', 'informasi_wisata', 
            'biaya_wisata', 'kategori', 'lokasi'
        ]));

        return response()->json([
            'status' => 1,
            'message' => 'Data wisata berhasil diperbarui',
            'data' => $wisata
        ]);
    }

    public function patch(Request $request, Wisata $wisata)
    {
        $rules = [];

        if ($request->has('nama_wisata')) $rules['nama_wisata'] = 'string|max:255';
        if ($request->has('alamat_wisata')) $rules['alamat_wisata'] = 'string';
        if ($request->has('informasi_wisata')) $rules['informasi_wisata'] = 'string';
        if ($request->has('biaya_wisata')) $rules['biaya_wisata'] = 'numeric';
        if ($request->has('kategori')) $rules['kategori'] = 'string|max:50';
        if ($request->has('lokasi')) $rules['lokasi'] = 'string';
        if ($request->hasFile('foto_wisata')) $rules['foto_wisata'] = 'image|max:2048';

        $request->validate($rules);

        foreach ($rules as $key => $rule) {
            if ($key === 'foto_wisata') {
                $wisata->foto_wisata = $request->file('foto_wisata')->store('wisata', 'public');
            } else {
                $wisata->$key = $request->$key;
            }
        }

        $wisata->save();

        return response()->json([
            'status' => 1,
            'message' => 'Data wisata berhasil diperbarui',
            'data' => $wisata
        ]);
    }

    public function destroy(Wisata $wisata)
    {
        $wisata->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Data wisata berhasil dihapus'
        ]);
    }
}
