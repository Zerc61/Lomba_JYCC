<?php

namespace App\Http\Controllers;

use App\Models\Penginapan;
use Illuminate\Http\Request;

class PenginapanController extends Controller
{
    public function index()
    {
        $penginapan = Penginapan::latest()->paginate(10);

        return response()->json([
            'status' => 1,
            'data' => $penginapan
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_penginapan' => 'required|string',
            'alamat_penginapan' => 'required|string',
            'informasi_penginapan' => 'nullable|string',
            'biaya_penginapan' => 'required|numeric',
            'kategori' => 'required|string',
            'lokasi' => 'required|string',
            'foto_penginapan' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $data = $request->except('foto_penginapan');

        // simpan file
        if ($request->hasFile('foto_penginapan')) {
            $file = $request->file('foto_penginapan');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/penginapan', $filename);
            $data['foto_penginapan'] = $filename;
        }

        $penginapan = Penginapan::create($data);

        return response()->json([
            "status" => 1,
            "data" => $penginapan,
            "msg" => "Penginapan created successfully"
        ]);
    }

    public function show($id)
    {
        $penginapan = Penginapan::find($id);

        if (!$penginapan) {
            return response()->json([
                "status" => 0,
                "msg" => "Penginapan not found"
            ], 404);
        }

        return response()->json([
            "status" => 1,
            "data" => $penginapan
        ]);
    }

    public function update(Request $request, $id)
    {
        $penginapan = Penginapan::find($id);

        if (!$penginapan) {
            return response()->json([
                "status" => 0,
                "msg" => "Penginapan not found"
            ], 404);
        }

        $request->validate([
            'nama_penginapan' => 'required|string',
            'alamat_penginapan' => 'required|string',
            'informasi_penginapan' => 'nullable|string',
            'biaya_penginapan' => 'required|numeric',
            'kategori' => 'required|string',
            'lokasi' => 'required|string',
            'foto_penginapan' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $data = $request->except('foto_penginapan');

        if ($request->hasFile('foto_penginapan')) {
            $file = $request->file('foto_penginapan');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/penginapan', $filename);
            $data['foto_penginapan'] = $filename;
        }

        $penginapan->update($data);

        return response()->json([
            "status" => 1,
            "msg" => "Penginapan updated successfully",
            "data" => $penginapan
        ]);
    }

    public function patch(Request $request, $id)
    {
        $penginapan = Penginapan::find($id);

        if (!$penginapan) {
            return response()->json([
                "status" => 0,
                "msg" => "Penginapan not found"
            ], 404);
        }

        $rules = [];

        foreach ([
            'nama_penginapan', 'alamat_penginapan', 'informasi_penginapan',
            'biaya_penginapan', 'kategori', 'lokasi'
        ] as $field) {
            if ($request->has($field)) {
                $rules[$field] = ($field == 'biaya_penginapan') ? 'numeric' : 'string';
            }
        }

        $request->validate($rules);

        $penginapan->update($request->only(array_keys($rules)));

        return response()->json([
            "status" => 1,
            "msg" => "Penginapan patched successfully",
            "data" => $penginapan
        ]);
    }

    public function destroy($id)
    {
        $penginapan = Penginapan::find($id);

        if (!$penginapan) {
            return response()->json([
                "status" => 0,
                "msg" => "Penginapan not found"
            ], 404);
        }

        $penginapan->delete();

        return response()->json([
            "status" => 1,
            "msg" => "Penginapan deleted successfully"
        ]);
    }
}

