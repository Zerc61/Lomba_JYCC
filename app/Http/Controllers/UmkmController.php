<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    // ============================
    // GET ALL UMKM (PAGINATION)
    // ============================
    public function index()
    {
        $umkm = Umkm::latest()->paginate(10);

        return response()->json([
            "status" => 1,
            "total"  => $umkm->total(),      // jumlah total UMKM
            "data"   => $umkm->items(),      // hanya array data
            "paging" => [
                "current_page" => $umkm->currentPage(),
                "per_page"     => $umkm->perPage(),
                "last_page"    => $umkm->lastPage()
            ]
        ]);
    }

    // ============================
    // STORE UMKM
    // ============================
   public function store(Request $request)
{
    $validated = $request->validate([
        'nama_umkm' => 'required',
        'pemilik' => 'required',
        'informasi_umkm' => 'required',
        'kategori' => 'required',
        'jam_buka' => 'nullable|date_format:H:i',
        'jam_tutup' => 'nullable|date_format:H:i',
        'foto_umkm' => 'nullable', // Base64 string
    ]);

    // Convert jam ke format MySQL
    if ($request->jam_buka) {
        $validated['jam_buka'] = now()->format('Y-m-d') . ' ' . $request->jam_buka . ':00';
    }

    if ($request->jam_tutup) {
        $validated['jam_tutup'] = now()->format('Y-m-d') . ' ' . $request->jam_tutup . ':00';
    }

    // Simpan ke database
    $umkm = Umkm::create($validated);

    return response()->json([
        'status' => 1,
        'message' => 'Data UMKM berhasil dibuat',
        'data' => $umkm
    ]);
}


    // ============================
    // SHOW DETAIL
    // ============================
    public function show(Umkm $umkm)
    {
        return response()->json([
            "status" => 1,
            "data"   => $umkm
        ]);
    }

    // ============================
    // UPDATE UMKM (PUT)
    // ============================
    public function update(Request $request, Umkm $umkm)
    {
        $request->validate([
            'nama_umkm'      => 'required|string|max:30',
            'pemilik'        => 'required|string|max:30',
            'informasi_umkm' => 'required|string',
            'kategori'       => 'required|in:kuliner,makanan_olahan,fashion,kerajinan_tangan,jasa,agribisnis,it_teknologi,peternakan,perdagangan',
            'jam_buka'       => 'nullable|date_format:H:i',
            'jam_tutup'      => 'nullable|date_format:H:i',
            'foto_umkm'      => 'nullable|image|max:2048'
        ]);

        // HAPUS FOTO LAMA + UPLOAD BARU
        if ($request->hasFile('foto_umkm')) {
            if ($umkm->foto_umkm) {
                Storage::disk('public')->delete($umkm->foto_umkm);
            }
            $umkm->foto_umkm = $request->file('foto_umkm')->store('umkm', 'public');
        }

        $umkm->update($request->only([
            'nama_umkm',
            'pemilik',
            'informasi_umkm',
            'kategori',
            'jam_buka',
            'jam_tutup'
        ]));

        return response()->json([
            "status"  => 1,
            "message" => "UMKM berhasil diperbarui",
            "data"    => $umkm
        ]);
    }

    // ============================
    // PATCH (PARTIAL UPDATE)
    // ============================
    public function patch(Request $request, Umkm $umkm)
    {
        $rules = [];

        $fields = ['nama_umkm', 'pemilik', 'informasi_umkm', 'kategori', 'jam_buka', 'jam_tutup'];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                if (in_array($field, ['nama_umkm', 'pemilik'])) {
                    $rules[$field] = 'string|max:30';
                } elseif ($field == 'informasi_umkm') {
                    $rules[$field] = 'string';
                } elseif ($field == 'kategori') {
                    $rules[$field] = 'in:kuliner,makanan_olahan,fashion,kerajinan_tangan,jasa,agribisnis,it_teknologi,peternakan,perdagangan';
                } elseif (in_array($field, ['jam_buka', 'jam_tutup'])) {
                    $rules[$field] = 'date_format:H:i';
                }
            }
        }

        if ($request->hasFile('foto_umkm')) {
            $rules['foto_umkm'] = 'image|max:2048';
        }

        $request->validate($rules);

        foreach ($rules as $field => $rule) {
            if ($field === 'foto_umkm') {
                if ($umkm->foto_umkm) {
                    Storage::disk('public')->delete($umkm->foto_umkm);
                }
                $umkm->foto_umkm = $request->file('foto_umkm')->store('umkm', 'public');
            } else {
                $umkm->$field = $request->$field;
            }
        }

        $umkm->save();

        return response()->json([
            "status"  => 1,
            "message" => "UMKM berhasil diperbarui",
            "data"    => $umkm
        ]);
    }

    // ============================
    // DELETE
    // ============================
    public function destroy(Umkm $umkm)
    {
        if ($umkm->foto_umkm) {
            Storage::disk('public')->delete($umkm->foto_umkm);
        }

        $umkm->delete();

        return response()->json([
            "status"  => 1,
            "message" => "UMKM berhasil dihapus"
        ]);
    }
}
