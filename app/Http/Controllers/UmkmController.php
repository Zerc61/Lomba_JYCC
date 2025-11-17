<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;

class UmkmController extends Controller
{
    public function index()
    {
        $umkm = Umkm::latest()->paginate(10);

        return response()->json([
            'status' => 1,
            'data' => $umkm
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
          'nama_umkm' => 'required|string|max:30',
          'pemilik' => 'required|string|max:30',
          'informasi_umkm' => 'required|string',
          'pasokan_umkm' => 'required|integer',
          'harga' => 'required|numeric',
          'kategori' => 'required|string|max:30',
          'foto_umkm' => 'nullable|image|max:2048',
          'jam_buka' => 'nullable|date',
          'jam_tutup' => 'nullable|date'
       ]);


        $foto = null;

        if ($request->hasFile('foto_umkm')) {
            $foto = file_get_contents($request->file('foto_umkm'));
        }

        $umkm = Umkm::create([
            'nama_umkm' => $request->nama_umkm,
            'pemilik' => $request->pemilik,
            'informasi_umkm' => $request->informasi_umkm,
            'pasokan_umkm' => $request->pasokan_umkm,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
            'jam_buka' => $request->jam_buka,
            'jam_tutup' => $request->jam_tutup,
            'foto_umkm' => $foto
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'Umkm berhasil ditambahkan',
            'data' => $umkm
        ]);
    }

    public function show(Umkm $umkm)
    {
        return response()->json([
            'status' => 1,
            'data' => $umkm
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Umkm $umkm)
    {
        $request->validate([
          'nama_umkm' => 'required|string|max:30',
          'pemilik' => 'required|string|max:30',
          'informasi_umkm' => 'required|string',
          'pasokan_umkm' => 'required|integer',
          'harga' => 'required|numeric',
          'kategori' => 'required|string|max:30',
          'foto_umkm' => 'nullable|image|max:2048',
          'jam_buka' => 'nullable|date',
          'jam_tutup' => 'nullable|date'
       ]);


        $foto = $umkm->foto_umkm;

        if ($request->hasFile('foto_umkm')) {
            $foto = file_get_contents($request->file('foto_umkm'));
        }

        $umkm->update([
            'nama_umkm' => $request->nama_umkm,
            'pemilik' => $request->pemilik,
            'informasi_umkm' => $request->informasi_umkm,
            'pasokan_umkm' => $request->pasokan_umkm,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
            'jam_buka' => $request->jam_buka,
            'jam_tutup' => $request->jam_tutup,
            'foto_umkm' => $foto
        ]);

           return response()->json([
            'status' => 1,
            'message' => 'UMKM berhasil diperbarui',
            'data' => $umkm
        ]);
    }


    public function patch(Request $request, Umkm $umkm) {
        $rules = [];

        if($request->has('nama_umkm')){
            $rules['nama_umkm'] = 'string|max:30';
        }

        if($request->has('pemilik')){
            $rules['pemiik'] = 'string|max:30';
        }

        if($request->has('informasi_umkm')){
            $rules['informasi_umkm'] = 'string';
        }

        if($request->has('pasokan_umkm')){
            $rules['nama_umkm'] = 'integer';
        }

        if($request->has('harga')){
            $rules['harga'] = 'numeric';
        }

        if($request->has('kategori')){
            $rules['nama_umkm'] = 'string|max:30';
        }

        if($request->has('jam_buka')){
            $rules['jam_buka'] = 'date';
        }
        if($request->has('jam_tutup')){
            $rules['jam_tutup'] = 'date';
        }
           if ($request->hasFile('foto_umkm')) {
            $rules['foto_umkm'] = 'image|max:2048';
        }

        $request->validate($rules);

        foreach ($request->only(array_keys($rules)) as $key => $value) {
            if ($key === 'foto_umkm'){
                $umkm->foto_umkm = file_get_contents($request->file('foto_umkm'));
            } else {
                $umkm->$key = $value;
            }
        }

        $umkm -> save();


        return response()->json([
            'status' => 1,
            'message' => 'umkm berhasil diperbarui',
            'data' => $umkm
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Umkm $umkm)
    {
        $umkm->delete();

        return response()->json([
            'status' => 1,
            'message' => 'UMKM berhasil dihapus'
        ]);
    }
}
