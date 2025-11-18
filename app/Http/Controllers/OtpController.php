<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Otp;

class OtpController extends Controller
{
    public function index()
    {
        return [
            "status" => 1,
            "data" => Otp::latest()->paginate(10)
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'otp_kode' => 'required|string|max:6'
        ]);

        $data = Otp::create($request->all());

        return [
            "status" => 1,
            "data" => $data
        ];
    }

    public function show(Otp $otp)
    {
        return [
            "status" => 1,
            "data" => $otp
        ];
    }

    public function update(Request $request, Otp $otp)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'otp_kode' => 'required|string|max:6'
        ]);

        $otp->update($request->all());

        return [
            "status" => 1,
            "data" => $otp,
            "msg" => "Otp updated successfully"
        ];
    }

    public function patch(Request $request, Otp $otp)
    {
        $otp->update($request->all());

        return [
            "status" => 1,
            "data" => $otp,
            "msg" => "Otp partially updated successfully"
        ];
    }

    public function destroy(Otp $otp)
    {
        $otp->delete();

        return [
            "status" => 1,
            "msg" => "Otp deleted successfully"
        ];
    }
}
