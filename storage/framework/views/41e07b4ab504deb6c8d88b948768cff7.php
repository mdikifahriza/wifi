<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beli Wifi - Generate QRIS</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex flex-col items-center justify-center min-h-screen bg-gray-100">

    
    <div class="flex flex-col items-center mb-6">
        <svg xmlns="http://www.w3.org/2000/svg"
             fill="none"
             viewBox="0 0 24 24"
             stroke-width="1.5"
             stroke="currentColor"
             class="w-20 h-20 text-blue-500 animate-pulse">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M8.288 15.712a5 5 0 017.424 0M5.1 12.525a9 9 0 0113.8 0M2.292 9.292a13 13 0 0119.416 0M12 18h.01" />
        </svg>
        <h1 class="text-2xl font-semibold text-gray-700 mt-3">Beli Akses Wi-Fi</h1>
        <p class="text-sm text-gray-500 mt-1">Pembayaran menggunakan QRIS via Midtrans Sandbox</p>
    </div>

    
    <form action="<?php echo e(route('generate.qr')); ?>" method="POST"
          class="bg-white p-6 rounded-2xl shadow-lg w-80 border border-gray-200">
        <?php echo csrf_field(); ?>

        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm mb-1">Nama</label>
            <input type="text" name="name"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-300"
                   placeholder="Nama lengkap" required>
        </div>

        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm mb-1">NIM</label>
            <input type="number" name="NIM"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-300"
                   placeholder="Nomor Induk Mahasiswa" required>
        </div>

        
        <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 active:scale-[0.98] transition duration-150">
            Beli dengan QRIS
        </button>

        
        <p class="text-xs text-gray-500 text-center mt-3">
            Setelah klik tombol, tunggu QR muncul di halaman berikutnya.
        </p>
    </form>

    
    <p class="text-gray-400 text-xs mt-8">© <?php echo e(date('Y')); ?> WiFi Payment System by Laravel x Midtrans</p>

</body>
</html>
<?php /**PATH C:\laragon\www\parkir - Copy\resources\views/LOG.blade.php ENDPATH**/ ?>