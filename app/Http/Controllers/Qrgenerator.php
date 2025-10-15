<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\CoreApi;

class Qrgenerator extends Controller
{
    public function createQrispayment(Request $req)
    {
        // Validasi input
        $req->validate([
            'name'  => 'required|string|max:50',
            'NIM'   => 'required|numeric|min:0',
            'harga' => 'required|numeric|min:0',
        ]);

        // Konfigurasi Midtrans
        Config::$serverKey     = config("midtrans.server_key");
        Config::$isProduction  = config("midtrans.is_production");
        Config::$isSanitized   = config("midtrans.is_sanitized", true);
        Config::$is3ds         = config("midtrans.is_3ds", true);

        // Data transaksi
        $params = [
            'payment_type' => 'qris',
            'transaction_details' => [
                'order_id'      => 'PAR-' . uniqid(),
                'gross_amount'  => $req->harga,
            ],
            'customer_details' => [
                'first_name' => $req->name,
                'email'      => "{$req->NIM}.student@unisba.ac",
            ],
        ];

        try {
            $response = CoreApi::charge($params);
            return response()->json($response);
        } catch (\Exception $err) {
            return response()->json([
                'error' => $err->getMessage(),
            ], 500);
        }
    }
}
