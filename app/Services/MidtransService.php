<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\CoreApi;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    public function createGoPayQR($orderId, $amount)
    {
        $params = [
            'payment_type' => 'gopay',
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'gopay' => [
                'enable_callback' => true,
                'callback_url' => route('midtrans.callback'),
            ],
        ];

        return CoreApi::charge($params);
    }
}
