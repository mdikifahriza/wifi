@if ($type == 'err')
    <div class="alert alert-danger text-center mt-4">
        {{ $message ?? "Transaksi error" }}
    </div>
@elseif ($type == 'status')
    <div class="alert 
        @if($status == 'capture' || $status == 'settlement') alert-success
        @elseif($status == 'pending') alert-warning
        @else alert-danger @endif text-center mt-4">
        <h5>{{ $message }}</h5>
        <p>Order ID: {{ $orderId ?? '-' }}</p>
    </div>
@else
    @switch($type)
        @case('qris')
            <div class="text-center mt-3">
                <h5>Scan QR di bawah untuk membayar:</h5>
                <x-Qrcode
                    :src="$src"
                    :type="$type"
                    :mataUang="$mataUang"
                    :rp="$Rp"
                    class="qr"/>
            </div>
            @break
        @default
            <div class="alert alert-secondary text-center mt-4">
                Transaksi sedang diproses...
            </div>
    @endswitch
@endif

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
