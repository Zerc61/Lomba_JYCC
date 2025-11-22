<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Wisata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class WisataController extends Controller
{
    public function index()
    {
        $wisatas = Wisata::orderBy('created_at', 'desc')->get();

        return response()->json([
            'status' => 1,
            'total' => $wisatas->count(),
            'message' => 'Data wisata berhasil dimuat.',
            'data' => $wisatas,
        ]);
    }

    public function store(Request $request)
    {
        // Validasi tanpa id_user dan nama_user
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

            if ($request->hasFile('foto_wisata')) {
                $file = $request->file('foto_wisata');
                $filename = time() . '-' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('public/wisatas', $filename);
                $data['foto_wisata'] = Storage::url($path);
            } else {
                $data['foto_wisata'] = null;
            }

            $wisata = Wisata::create($data);

            return response()->json([
                'status' => 1,
                'message' => 'Wisata berhasil ditambahkan.',
                'data' => $wisata,
            ], 201);

        } catch (\Exception $e) {
            if (isset($path)) {
                Storage::delete($path);
            }
            return response()->json([
                'status' => 0,
                'message' => 'Gagal menyimpan data wisata: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $wisata = Wisata::find($id);

        if (!$wisata) {
            return response()->json(['status' => 0, 'message' => 'Wisata tidak ditemukan.'], 404);
        }

        // Validasi tanpa id_user dan nama_user
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
                if ($wisata->foto_wisata && strpos($wisata->foto_wisata, '/storage/') !== false) {
                    $relativePath = str_replace('/storage/', 'public/', $wisata->foto_wisata);
                    Storage::delete($relativePath);
                }

                $file = $request->file('foto_wisata');
                $filename = time() . '-' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('public/wisatas', $filename);
                $data['foto_wisata'] = Storage::url($path);
            }

            $wisata->update($data);

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

    public function destroy($id)
    {
        $wisata = Wisata::find($id);

        if (!$wisata) {
            return response()->json(['status' => 0, 'message' => 'Wisata tidak ditemukan.'], 404);
        }

        try {
            if ($wisata->foto_wisata && strpos($wisata->foto_wisata, '/storage/') !== false) {
                $relativePath = str_replace('/storage/', 'public/', $wisata->foto_wisata);
                Storage::delete($relativePath);
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
