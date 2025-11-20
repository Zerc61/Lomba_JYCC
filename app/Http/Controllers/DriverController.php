<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::latest()->get();
        // Ubah foto binary ke base64 supaya bisa ditampilkan di frontend
        $drivers->transform(function($d) {
            $d->foto_driver = $d->foto_driver ? 'data:image/jpeg;base64,' . base64_encode($d->foto_driver) : null;
            return $d;
        });

        return response()->json([
            'status' => 1,
            'data' => $drivers,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:30',
            'foto_driver' => 'nullable|image|max:2048',
        ]);

        $driver = new Driver();
        $driver->nama = $request->nama;
        $driver->umur = $request->umur;
        $driver->jenis_kelamin = $request->jenis_kelamin;
        $driver->no_hp = $request->no_hp;
        $driver->email = $request->email;
        $driver->rating = $request->rating;
        $driver->alamat = $request->alamat;

        if ($request->hasFile('foto_driver')) {
            $driver->foto_driver = file_get_contents($request->file('foto_driver')->getRealPath());
        }

        $driver->save();

        return response()->json(['status' => 1, 'message' => 'Driver berhasil ditambahkan']);
    }

    public function update(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);

        $driver->nama = $request->nama ?? $driver->nama;
        $driver->umur = $request->umur ?? $driver->umur;
        $driver->jenis_kelamin = $request->jenis_kelamin ?? $driver->jenis_kelamin;
        $driver->no_hp = $request->no_hp ?? $driver->no_hp;
        $driver->email = $request->email ?? $driver->email;
        $driver->rating = $request->rating ?? $driver->rating;
        $driver->alamat = $request->alamat ?? $driver->alamat;

        if ($request->hasFile('foto_driver')) {
            $driver->foto_driver = file_get_contents($request->file('foto_driver')->getRealPath());
        }

        $driver->save();

        return response()->json(['status' => 1, 'message' => 'Driver berhasil diupdate']);
    }

    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->delete();

        return response()->json(['status' => 1, 'message' => 'Driver berhasil dihapus']);
    }
}
