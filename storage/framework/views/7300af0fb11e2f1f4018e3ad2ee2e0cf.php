<?php if($type == 'err'): ?>
    <div class="alert alert-danger text-center mt-4">
        <?php echo e($message ?? "Transaksi error"); ?>

    </div>
<?php elseif($type == 'status'): ?>
    <div class="alert 
        <?php if($status == 'capture' || $status == 'settlement'): ?> alert-success
        <?php elseif($status == 'pending'): ?> alert-warning
        <?php else: ?> alert-danger <?php endif; ?> text-center mt-4">
        <h5><?php echo e($message); ?></h5>
        <p>Order ID: <?php echo e($orderId ?? '-'); ?></p>
    </div>
<?php else: ?>
    <?php switch($type):
        case ('qris'): ?>
            <div class="text-center mt-3">
                <h5>Scan QR di bawah untuk membayar:</h5>
                <?php if (isset($component)) { $__componentOriginale01c72cadde667e91dc79c4da80c5097 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale01c72cadde667e91dc79c4da80c5097 = $attributes; } ?>
<?php $component = App\View\Components\Qrcode::resolve(['src' => $src,'type' => $type,'mataUang' => $mataUang,'rp' => $Rp] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('Qrcode'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Qrcode::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'qr']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale01c72cadde667e91dc79c4da80c5097)): ?>
<?php $attributes = $__attributesOriginale01c72cadde667e91dc79c4da80c5097; ?>
<?php unset($__attributesOriginale01c72cadde667e91dc79c4da80c5097); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale01c72cadde667e91dc79c4da80c5097)): ?>
<?php $component = $__componentOriginale01c72cadde667e91dc79c4da80c5097; ?>
<?php unset($__componentOriginale01c72cadde667e91dc79c4da80c5097); ?>
<?php endif; ?>
            </div>
            <?php break; ?>
        <?php default: ?>
            <div class="alert alert-secondary text-center mt-4">
                Transaksi sedang diproses...
            </div>
    <?php endswitch; ?>
<?php endif; ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<?php /**PATH C:\laragon\www\parkir - Copy\resources\views/displaytransaction.blade.php ENDPATH**/ ?>