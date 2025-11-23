<?php

namespace App\Http\Controllers;

use App\Models\Wisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class WisataController extends Controller
{
    // Menampilkan semua wisata
    public function index()
    {
        $wisatas = Wisata::orderBy('created_at', 'desc')->get();

        $wisatas->each(function($item) {
            $item->harga_dcoin = round($item->biaya_wisata / 1000);
        });

        return response()->json([
            'status' => 1,
            'total' => $wisatas->count(),
            'message' => 'Data wisata berhasil dimuat.',
            'data' => $wisatas,
        ]);
    }

    // Menambahkan wisata baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'alamat_wisata' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'biaya_wisata' => 'required|integer|min:0',
            'lokasi' => 'required|string|max:255',
            'foto_wisata' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $data = $request->except('foto_wisata');
            $data['biaya_wisata'] = (int) $data['biaya_wisata'];

            // Upload foto jika ada
            if ($request->hasFile('foto_wisata')) {
                $file = $request->file('foto_wisata');
                $filename = time() . '-' . Str::random(10) . '.' . $file->getClientOriginalExtension();

                // Simpan ke storage/app/public/wisatas
                $file->storeAs('public/wisatas', $filename);

                // Simpan URL untuk public access
                $data['foto_wisata'] = '/storage/wisatas/' . $filename;
            } else {
                $data['foto_wisata'] = null;
            }

            $wisata = Wisata::create($data);
            $wisata->harga_dcoin = round($wisata->biaya_wisata / 1000);

            return response()->json([
                'status' => 1,
                'message' => 'Wisata berhasil ditambahkan.',
                'data' => $wisata,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Gagal menyimpan data wisata: ' . $e->getMessage()
            ], 500);
        }
    }

    // Menampilkan detail wisata
    public function show($id)
    {
        $wisata = Wisata::find($id);

        if (!$wisata) {
            return response()->json([
                'status' => 0,
                'message' => 'Wisata tidak ditemukan.'
            ], 404);
        }

        $wisata->harga_dcoin = round($wisata->biaya_wisata / 1000);

        return response()->json([
            'status' => 1,
            'data' => $wisata,
            'message' => 'Data wisata berhasil dimuat.'
        ]);
    }

    // Update wisata
    public function update(Request $request, $id)
    {
        $wisata = Wisata::find($id);

        if (!$wisata) {
            return response()->json(['status' => 0, 'message' => 'Wisata tidak ditemukan.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'alamat_wisata' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'biaya_wisata' => 'required|integer|min:0',
            'lokasi' => 'required|string|max:255',
            'foto_wisata' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $data = $request->except('foto_wisata', '_method');
            $data['biaya_wisata'] = (int) $data['biaya_wisata'];

            if ($request->hasFile('foto_wisata')) {
                // Hapus foto lama jika ada
                if ($wisata->foto_wisata) {
                    $oldPath = str_replace('/storage/', 'public/', $wisata->foto_wisata);
                    Storage::delete($oldPath);
                }

                $file = $request->file('foto_wisata');
                $filename = time() . '-' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/wisatas', $filename);

                $data['foto_wisata'] = '/storage/wisatas/' . $filename;
            }

            $wisata->update($data);
            $wisata->harga_dcoin = round($wisata->biaya_wisata / 1000);

            return response()->json([
                'status' => 1,
                'message' => 'Wisata berhasil diupdate.',
                'data' => $wisata,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Gagal mengupdate data wisata: ' . $e->getMessage()
            ], 500);
        }
    }

    // Hapus wisata
    public function destroy($id)
    {
        $wisata = Wisata::find($id);

        if (!$wisata) {
            return response()->json(['status' => 0, 'message' => 'Wisata tidak ditemukan.'], 404);
        }

        try {
            if ($wisata->foto_wisata) {
                $relative = str_replace('/storage/', 'public/', $wisata->foto_wisata);
                Storage::delete($relative);
            }

            $wisata->delete();

            return response()->json([
                'status' => 1,
                'message' => 'Wisata berhasil dihapus.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Gagal menghapus data wisata: ' . $e->getMessage()
            ], 500);
        }
    }
}
