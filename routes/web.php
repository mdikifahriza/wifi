<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Qrgenerator;
use Midtrans\Notification;
use Midtrans\CoreApi;

// ==========================
// 1️⃣ Halaman utama (form input)
// ==========================
Route::get('/', function () {
    return view('LOG');
})->name('home');


// ==========================
// 2️⃣ Generate QRIS
// ==========================
Route::post('/generate-qr', function (Request $req) {
    $req->merge(['harga' => 2000]); // harga tetap

    $controller = app(Qrgenerator::class);
    $response = $controller->createQrispayment($req)->getData(true);

    $statusCode = $response['status_code'] ?? 500;
    $success = isset($statusCode) && (int)$statusCode < 400;

    return view('displaytransaction', [
        'type'      => $success ? ($response['payment_type'] ?? 'unknown') : 'err',
        'message'   => $response['status_message'] ?? ($response['error'] ?? 'Terjadi kesalahan'),
        'mataUang'  => $response['currency'] ?? '-',
        'src'       => $response['actions'][0]['url'] ?? null,
        'Rp'        => $response['gross_amount'] ?? 0,
        'orderId'   => $response['order_id'] ?? null,
        'status'    => 'pending'
    ]);
})->name('generate.qr');


// ==========================
// 3️⃣ Callback / Notifikasi Midtrans
// ==========================
Route::post('/payment/notification', function (Request $request) {
    $notif = new Notification();

    $transaction = $notif->transaction_status;
    $orderId     = $notif->order_id;
    $fraud       = $notif->fraud_status ?? null;

    $statusMessage = match ($transaction) {
        'capture', 'settlement' => 'Pembayaran berhasil ✅',
        'pending'               => 'Menunggu pembayaran...',
        'deny', 'expire', 'cancel' => 'Pembayaran gagal ❌',
        default                 => 'Status tidak diketahui'
    };

    return view('displaytransaction', [
        'type'      => 'status',
        'message'   => $statusMessage,
        'orderId'   => $orderId,
        'status'    => $transaction,
        'mataUang'  => '-',
        'Rp'        => '-',
        'src'       => null,
    ]);
})->name('payment.notification');


// ==========================
// 4️⃣ Cek Status Manual (dari tombol “Cek Status Pembayaran”)
// ==========================
Route::get('/payment/status', function (Request $request) {
    $orderId = $request->query('order_id');

    if (!$orderId) {
        return redirect()->route('home')->with('error', 'Order ID tidak ditemukan.');
    }

    try {
        $response = CoreApi::status($orderId);

        $transaction = $response->transaction_status ?? 'unknown';
        $statusMessage = match ($transaction) {
            'capture', 'settlement' => 'Pembayaran berhasil ✅',
            'pending'               => 'Masih menunggu pembayaran...',
            'deny', 'expire', 'cancel' => 'Pembayaran gagal ❌',
            default                 => 'Status tidak diketahui'
        };

        return view('displaytransaction', [
            'type'      => 'status',
            'message'   => $statusMessage,
            'orderId'   => $orderId,
            'status'    => $transaction,
            'Rp'        => $response->gross_amount ?? '-',
            'mataUang'  => $response->currency ?? '-',
            'src'       => null,
        ]);
    } catch (\Exception $e) {
        return view('displaytransaction', [
            'type'      => 'err',
            'message'   => 'Gagal memeriksa status: ' . $e->getMessage(),
        ]);
    }
})->name('check.status');
