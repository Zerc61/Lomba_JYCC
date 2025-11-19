<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    public function index()
    {
        $umkm = Umkm::latest()->paginate(10);
        return response()->json(['status' => 1, 'data' => $umkm]);
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
            'jam_tutup' => 'nullable|date',
        ]);

        $fotoPath = $request->hasFile('foto_umkm') 
            ? $request->file('foto_umkm')->store('umkm', 'public') 
            : null;

        $umkm = Umkm::create([
            'nama_umkm' => $request->nama_umkm,
            'pemilik' => $request->pemilik,
            'informasi_umkm' => $request->informasi_umkm,
            'pasokan_umkm' => $request->pasokan_umkm,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
            'jam_buka' => $request->jam_buka,
            'jam_tutup' => $request->jam_tutup,
            'foto_umkm' => $fotoPath,
        ]);

        return response()->json(['status' => 1, 'message' => 'UMKM berhasil ditambahkan', 'data' => $umkm]);
    }

    public function show(Umkm $umkm)
    {
        return response()->json(['status' => 1, 'data' => $umkm]);
    }

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
            'jam_tutup' => 'nullable|date',
        ]);

        if ($request->hasFile('foto_umkm')) {
            $umkm->foto_umkm = $request->file('foto_umkm')->store('umkm', 'public');
        }

        $umkm->update($request->only([
            'nama_umkm', 'pemilik', 'informasi_umkm', 'pasokan_umkm', 'harga', 'kategori', 'jam_buka', 'jam_tutup'
        ]));

        return response()->json(['status' => 1, 'message' => 'UMKM berhasil diperbarui', 'data' => $umkm]);
    }

    public function patch(Request $request, Umkm $umkm)
    {
        $rules = [];
        $fields = ['nama_umkm','pemilik','informasi_umkm','pasokan_umkm','harga','kategori','jam_buka','jam_tutup'];
        
        foreach ($fields as $field) {
            if ($request->has($field)) {
                switch($field) {
                    case 'nama_umkm':
                    case 'pemilik':
                    case 'kategori':
                        $rules[$field] = 'string|max:30';
                        break;
                    case 'informasi_umkm':
                        $rules[$field] = 'string';
                        break;
                    case 'pasokan_umkm':
                        $rules[$field] = 'integer';
                        break;
                    case 'harga':
                        $rules[$field] = 'numeric';
                        break;
                    case 'jam_buka':
                    case 'jam_tutup':
                        $rules[$field] = 'date';
                        break;
                }
            }
        }

        if ($request->hasFile('foto_umkm')) {
            $rules['foto_umkm'] = 'image|max:2048';
        }

        $request->validate($rules);

        foreach ($rules as $key => $value) {
            if ($key === 'foto_umkm') {
                $umkm->foto_umkm = $request->file('foto_umkm')->store('umkm', 'public');
            } else {
                $umkm->$key = $request->$key;
            }
        }

        $umkm->save();

        return response()->json(['status' => 1, 'message' => 'UMKM berhasil diperbarui', 'data' => $umkm]);
    }

    public function destroy(Umkm $umkm)
    {
        $umkm->delete();
        return response()->json(['status' => 1, 'message' => 'UMKM berhasil dihapus']);
    }
}
