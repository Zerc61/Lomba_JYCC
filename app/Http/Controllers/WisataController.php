<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wisata;

class WisataController extends Controller
{
    // LIST SEMUA WISATA
    public function index()
    {
        $wisatas = Wisata::latest()->paginate(10); 
        
        // Konversi data binary foto kembali ke Base64 saat mengirim ke frontend
        $data_wisata = $wisatas->map(function ($wisata) {
            if ($wisata->foto_wisata) {
                // Konversi binary ke Base64 string
                $wisata->foto_wisata_base64 = base64_encode($wisata->foto_wisata);
            }
            return $wisata;
        });

        return response()->json([
            'status' => 1,
            // Kembalikan data yang sudah dimodifikasi
            'data'   => $data_wisata,
            'paging' => [
                'current_page' => $wisatas->currentPage(),
                'last_page' => $wisatas->lastPage(),
                'total' => $wisatas->total(),
            ]
        ]);
    }

    // DETAIL WISATA
    public function show(Wisata $wisata)
    {
        // Konversi data binary foto kembali ke Base64 saat mengirim ke frontend
        if ($wisata->foto_wisata) {
            $wisata->foto_wisata_base64 = base64_encode($wisata->foto_wisata);
        }

        return response()->json([
            'status' => 1,
            'data' => $wisata
        ]);
    }

    // TAMBAH WISATA BARU
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'kategori' => 'required|in:Wisata Alam,Wisata Budaya,Wisata Sejarah,Wisata Religi,Wisata Kuliner,Wisata Belanja,Wisata Edukasi,Wisata Petualangan,Wisata Kesehatan',
            'alamat_wisata' => 'required|string',
            'deskripsi' => 'required',
            // Dibiarkan 'nullable' karena Base64 akan dikirim sebagai string
            'foto_wisata' => 'nullable', 
            'biaya_wisata' => 'required|numeric',
            'lokasi' => 'required|string|max:150',
        ]);

        // DIKEMBALIKAN: Dekode Base64 string menjadi binary data
        if ($request->foto_wisata) {
            $validated['foto_wisata'] = base64_decode($request->foto_wisata);
        } else {
            // Penting: Pastikan Base64 kosong saat null
            $validated['foto_wisata'] = null; 
        }

        $wisata = Wisata::create($validated);
        
        // Konversi balik foto yang baru dibuat untuk respons
        if ($wisata->foto_wisata) {
            $wisata->foto_wisata_base64 = base64_encode($wisata->foto_wisata);
        }

        return response()->json([
            'status' => 1,
            'message' => 'Wisata berhasil ditambahkan',
            'data' => $wisata
        ], 201);
    }

    // UPDATE PENUH (PUT)
    public function update(Request $request, Wisata $wisata)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:100',
            'kategori' => 'required|in:Wisata Alam,Wisata Budaya,Wisata Sejarah,Wisata Religi,Wisata Kuliner,Wisata Belanja,Wisata Edukasi,Wisata Petualangan,Wisata Kesehatan',
            'alamat_wisata' => 'required|string',
            'deskripsi' => 'required',
            'foto_wisata' => 'nullable',
            'biaya_wisata' => 'required|numeric',
            'lokasi' => 'required|string|max:150',
        ]);

        // DIKEMBALIKAN: Dekode Base64 string menjadi binary data
        if ($request->foto_wisata) {
            $validated['foto_wisata'] = base64_decode($request->foto_wisata);
        } else {
             // Jika Base64 dikirim null/kosong, set binary menjadi null
            $validated['foto_wisata'] = null;
        }

        $wisata->update($validated);
        
        // Konversi balik foto yang diupdate untuk respons
        if ($wisata->foto_wisata) {
            $wisata->foto_wisata_base64 = base64_encode($wisata->foto_wisata);
        }

        return response()->json([
            'status' => 1,
            'message' => 'Wisata berhasil diperbarui',
            'data' => $wisata
        ]);
    }

    // UPDATE SEBAGIAN (PATCH)
    public function patch(Request $request, Wisata $wisata)
    {
        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:100',
            'kategori' => 'sometimes|required|in:Wisata Alam,Wisata Budaya,Wisata Sejarah,Wisata Religi,Wisata Kuliner,Wisata Belanja,Wisata Edukasi,Wisata Petualangan,Wisata Kesehatan',
            'alamat_wisata' => 'sometimes|required|string',
            'deskripsi' => 'sometimes|required',
            'foto_wisata' => 'sometimes|nullable',
            'biaya_wisata' => 'sometimes|required|numeric',
            'lokasi' => 'sometimes|required|string|max:150',
        ]);

        // DIKEMBALIKAN: Dekode Base64 string menjadi binary data, HANYA JIKA ADA di request
        if ($request->has('foto_wisata')) {
            if ($request->foto_wisata) {
                $validated['foto_wisata'] = base64_decode($request->foto_wisata);
            } else {
                $validated['foto_wisata'] = null;
            }
        } else {
            // Penting: Jangan lakukan apa-apa jika foto_wisata tidak dikirimkan sama sekali
            unset($validated['foto_wisata']); 
        }

        $wisata->update($validated);

        // Konversi balik foto yang diupdate untuk respons
        if ($wisata->foto_wisata) {
            $wisata->foto_wisata_base64 = base64_encode($wisata->foto_wisata);
        }

        return response()->json([
            'status' => 1,
            'message' => 'Wisata berhasil diupdate sebagian',
            'data' => $wisata
        ]);
    }

    // HAPUS WISATA
    public function destroy(Wisata $wisata)
    {
        // Tidak ada yang perlu dihapus dari storage karena data disimpan di DB
        $wisata->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Wisata berhasil dihapus'
        ]);
    }
}