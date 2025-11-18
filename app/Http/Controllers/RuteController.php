<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rute;

class RuteController extends Controller
{
    public function index()
    {
        return [
            "status" => 1,
            "data" => Rute::latest()->paginate(10)
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_online' => 'required|integer',
            'id_umkm' => 'required|integer',
            'latitude' => 'required',
            'longitude' => 'required',
            'alamat' => 'required|string|max:100',
        ]);

        $data = Rute::create($request->all());

        return [
            "status" => 1,
            "data" => $data
        ];
    }

    public function show(Rute $rute)
    {
        return [
            "status" => 1,
            "data" => $rute
        ];
    }

    public function update(Request $request, Rute $rute)
    {
        $request->validate([
            'id_online' => 'required|integer',
            'id_umkm' => 'required|integer',
            'latitude' => 'required',
            'longitude' => 'required',
            'alamat' => 'required|string|max:100',
        ]);

        $rute->update($request->all());

        return [
            "status" => 1,
            "data" => $rute,
            "msg" => "Rute updated successfully"
        ];
    }

    public function patch(Request $request, Rute $rute)
    {
        $rute->update($request->all());

        return [
            "status" => 1,
            "data" => $rute,
            "msg" => "Rute partially updated successfully"
        ];
    }

    public function destroy(Rute $rute)
    {
        $rute->delete();

        return [
            "status" => 1,
            "msg" => "Rute deleted successfully"
        ];
    }
}
