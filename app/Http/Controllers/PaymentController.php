<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MidtransService;

class PaymentController extends Controller
{
    protected $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

    // Membuat transaksi GoPay QR
    public function pay(Request $request)
    {
        $orderId = 'ORDER-' . time();
        $amount  = $request->input('amount', 10000);

        $response = $this->midtrans->createGoPayQR($orderId, $amount);

        // Pastikan response berupa array
        return view('qrcode', [
            'orderId' => $orderId,
            'qrUrl'   => $response['actions'][0]['url'] ?? null,
        ]);
    }

    // Menerima callback dari Midtrans
    public function status(Request $request)
    {
        \Log::info('Midtrans Callback:', $request->all());

        $status = $request->transaction_status ?? 'unknown';
        $orderId = $request->order_id ?? null;

        switch ($status) {
            case 'settlement':
                $message = "Pembayaran untuk $orderId berhasil.";
                break;
            case 'pending':
                $message = "Pembayaran untuk $orderId sedang menunggu.";
                break;
            case 'expire':
                $message = "Pembayaran untuk $orderId telah kedaluwarsa.";
                break;
            default:
                $message = "Status transaksi tidak diketahui.";
        }

        return response()->json([
            'message' => $message,
            'data' => $request->all(),
        ]);
    }
}
