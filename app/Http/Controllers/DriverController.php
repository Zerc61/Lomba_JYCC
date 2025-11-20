<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::latest()->paginate(10);
        return response()->json([
            'status' => 1,
            'data' => $drivers,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:50',
            'umur' => 'nullable|integer',
            'rating' => 'nullable|numeric|min:0|max:5',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
        ]);

        $driver = Driver::create($validated);

        return response()->json([
            'status' => 1,
            'message' => 'Driver berhasil ditambahkan',
            'data' => $driver,
        ]);
    }

    public function show($id)
    {
        $driver = Driver::findOrFail($id);
        return response()->json($driver);
    }

    public function update(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:50',
            'umur' => 'nullable|integer',
            'rating' => 'nullable|numeric|min:0|max:5',
            'no_hp' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
        ]);

        $driver->update($validated);

        return response()->json([
            'status' => 1,
            'message' => 'Driver berhasil diperbarui',
            'data' => $driver,
        ]);
    }

    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Driver berhasil dihapus',
        ]);
    }
}
