<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Umkm;

class UmkmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $umkm = Umkm::latest()->paginate(10);

        return response()->json([
            'status' => 1,
            'data' => $umkm
        ]);


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pemiik' => 'required|string|max:30',
            'informasi_umkm' => 'required|string',
            'pasokan_umkm' => 'required|integer',
            'harga' => 'required|numeric',
            'kategori' => 'required|'
        ]);
    }

    /**
     * Display the specified resource.
     */
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
