<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TiketWisata;
use App\Models\Topup;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TiketWisataController extends Controller
{
    public function index()
    {
        $tiket = TiketWisata::latest()->paginate(10);

        return [
            "status" => 1,
            "data" => $tiket
        ];
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_wisata' => 'required|numeric',
            'id_user' => 'required|numeric',
            'jumlah_tiket' => 'required|numeric|min:1',
            'metode_pembayaran' => 'required|in:dcoin,rupiah',
        ]);

        try {
            // Dapatkan data wisata
            $wisata = \App\Models\Wisata::find($request->id_wisata);
            if (!$wisata) {
                return [
                    "status" => 0,
                    "msg" => "Wisata tidak ditemukan"
                ];
            }

            // Dapatkan data user/saldo
            $saldo = Topup::where('id_user', $request->id_user)->first();
            if (!$saldo) {
                return [
                    "status" => 0,
                    "msg" => "Data saldo tidak ditemukan"
                ];
            }

            // Hitung total harga
            $totalHargaDcoin = $wisata->harga_dcoin * $request->jumlah_tiket;
            $totalHargaRupiah = $wisata->biaya_wisata * $request->jumlah_tiket;

            // Validasi saldo
            if ($request->metode_pembayaran === 'dcoin' && $saldo->saldo_dcoin < $totalHargaDcoin) {
                return [
                    "status" => 0,
                    "msg" => "Saldo D-Coin tidak mencukupi"
                ];
            }

            if ($request->metode_pembayaran === 'rupiah' && $saldo->saldo_rupiah < $totalHargaRupiah) {
                return [
                    "status" => 0,
                    "msg" => "Saldo Rupiah tidak mencukupi"
                ];
            }

            // Buat tiket dengan status pending
            $tiket = TiketWisata::create([
                'id_wisata' => $request->id_wisata,
                'id_user' => $request->id_user,
                'jumlah_tiket' => $request->jumlah_tiket,
                'metode_pembayaran' => $request->metode_pembayaran,
                'total_harga_dcoin' => $totalHargaDcoin,
                'total_harga_rupiah' => $totalHargaRupiah,
                'status_pembayaran' => 'pending',
                'tanggal_pembelian' => Carbon::now(),
            ]);

            return [
                "status" => 1,
                "data" => $tiket,
                "msg" => "Tiket created successfully"
            ];

        } catch (\Exception $e) {
            return [
                "status" => 0,
                "msg" => "Insert error: " . $e->getMessage()
            ];
        }
    }

    public function confirm(Request $request, $id_tiket)
    {
        try {
            $tiket = TiketWisata::find($id_tiket);
            if (!$tiket) {
                return [
                    "status" => 0,
                    "msg" => "Tiket tidak ditemukan"
                ];
            }

            if ($tiket->status_pembayaran === 'confirmed') {
                return [
                    "status" => 0,
                    "msg" => "Tiket sudah dikonfirmasi"
                ];
            }

            // Dapatkan data user/saldo
            $saldo = Topup::where('id_user', $tiket->id_user)->first();
            if (!$saldo) {
                return [
                    "status" => 0,
                    "msg" => "Data saldo tidak ditemukan"
                ];
            }

            // Proses pengurangan saldo dan konfirmasi pembayaran
            DB::beginTransaction();

            try {
                if ($tiket->metode_pembayaran === 'dcoin') {
                    // Kurangi saldo D-Coin
                    $saldo->saldo_dcoin -= $tiket->total_harga_dcoin;
                } else {
                    // Kurangi saldo Rupiah
                    $saldo->saldo_rupiah -= $tiket->total_harga_rupiah;
                }

                $saldo->save();

                // Update status tiket
                $tiket->status_pembayaran = 'confirmed';
                $tiket->tanggal_konfirmasi = Carbon::now();
                $tiket->save();

                DB::commit();

                return [
                    "status" => 1,
                    "data" => $tiket,
                    "msg" => "Pembayaran berhasil dikonfirmasi"
                ];
            } catch (\Exception $e) {
                DB::rollback();
                return [
                    "status" => 0,
                    "msg" => "Error processing payment: " . $e->getMessage()
                ];
            }
        } catch (\Exception $e) {
            return [
                "status" => 0,
                "msg" => "Error confirming payment: " . $e->getMessage()
            ];
        }
    }

    public function show(TiketWisata $tiket)
    {
        return [
            "status" => 1,
            "data" => $tiket
        ];
    }

   public function myTickets(Request $request)
    {
        try {
            $user = $request->user(); // Mendapatkan user yang sedang login
            $tikets = TiketWisata::with('wisata') // Muat relasi 'wisata'
                ->where('id_user', $user->id_user) // Filter berdasarkan user yang login
                ->orderBy('tanggal_pembelian', 'desc') // Urutkan dari yang terbaru
                ->get();

            // Format data agar sesuai dengan yang diharapkan Vue
            $formattedTikets = $tikets->map(function ($tiket) {
                return [
                    'id_tiket' => $tiket->id_tiket,
                    'id_wisata' => $tiket->id_wisata,
                    'id_user' => $tiket->id_user,
                    'jumlah_tiket' => $tiket->jumlah_tiket,
                    'metode_pembayaran' => $tiket->metode_pembayaran,
                    'total_harga_rupiah' => $tiket->total_harga_rupiah,
                    'total_harga_dcoin' => $tiket->total_harga_dcoin,
                    // PERBAIKAN: Ubah 'status_pembayaran' menjadi 'status' dan 'confirmed' menjadi 'success'
                    'status' => $tiket->status_pembayaran === 'confirmed' ? 'success' : ($tiket->status_pembayaran === 'pending' ? 'pending' : 'failed'),
                    'tanggal_pembelian' => $tiket->tanggal_pembelian,
                    // PERBAIKAN: Tambahkan kode pembayaran unik
                    'kode_pembayaran' => 'TIX-' . str_pad($tiket->id_tiket, 8, '0', STR_PAD_LEFT),
                    // PERBAIKAN: Sertakan data wisata sebagai objek bersarang
                    'wisata' => [
                        'nama' => $tiket->wisata->nama,
                        'alamat_wisata' => $tiket->wisata->alamat_wisata,
                        'kategori' => $tiket->wisata->kategori,
                    ],
                ];
            });

            return [
                "status" => 1,
                "data" => $formattedTikets
            ];
        } catch (\Exception $e) {
            return [
                "status" => 0,
                "msg" => "Error fetching tickets: " . $e->getMessage()
            ];
        }
    }

       public function konfirmasi(Request $request, $id_tiket)
    {
        try {
            $tiket = TiketWisata::find($id_tiket);
            if (!$tiket) {
                return [
                    "status" => 0,
                    "msg" => "Tiket tidak ditemukan"
                ];
            }

            if ($tiket->status_pembayaran === 'confirmed') {
                return [
                    "status" => 0,
                    "msg" => "Tiket sudah dikonfirmasi"
                ];
            }

            // Dapatkan data user/saldo
            $saldo = Topup::where('id_user', $tiket->id_user)->first();
            if (!$saldo) {
                return [
                    "status" => 0,
                    "msg" => "Data saldo tidak ditemukan"
                ];
            }

            // Proses pengurangan saldo dan konfirmasi pembayaran
            DB::beginTransaction();

            try {
                if ($tiket->metode_pembayaran === 'dcoin') {
                    // Kurangi saldo D-Coin
                    $saldo->saldo_dcoin -= $tiket->total_harga_dcoin;
                } else {
                    // Kurangi saldo Rupiah
                    $saldo->saldo_rupiah -= $tiket->total_harga_rupiah;
                }

                $saldo->save();

                // Update status tiket
                $tiket->status_pembayaran = 'confirmed';
                $tiket->tanggal_konfirmasi = Carbon::now();
                $tiket->save();

                DB::commit();

                return [
                    "status" => 1,
                    "data" => $tiket,
                    "msg" => "Pembayaran berhasil dikonfirmasi"
                ];
            } catch (\Exception $e) {
                DB::rollback();
                return [
                    "status" => 0,
                    "msg" => "Error processing payment: " . $e->getMessage()
                ];
            }
        } catch (\Exception $e) {
            return [
                "status" => 0,
                "msg" => "Error confirming payment: " . $e->getMessage()
            ];
        }
    }

}