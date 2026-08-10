<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk <?php echo e($sale->invoice_number); ?></title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="text-center">
        <h2>APOTEK PINTAR</h2>
        <p>Struk Pembayaran Kasir</p>
    </div>
    <hr>
    <p><strong>No. Nota:</strong> <?php echo e($sale->invoice_number); ?></p>
    <p><strong>Tanggal:</strong> <?php echo e($sale->created_at); ?></p>
    <p><strong>Pasien:</strong> <?php echo e($sale->patient->name ?? 'Umum'); ?></p>

    <table>
        <thead>
            <tr>
                <th>Nama Obat</th>
                <th>Qty</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $sale->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <tr>
                <td><?php echo e($detail->medicine->nama_obat ?? '-'); ?></td>
                <td><?php echo e($detail->quantity); ?></td>
                <td class="text-right">Rp <?php echo e(number_format($detail->price, 0, ',', '.')); ?></td>
                <td class="text-right">Rp <?php echo e(number_format($detail->subtotal, 0, ',', '.')); ?></td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </tbody>
    </table>

    <h3 class="text-right">Total: Rp <?php echo e(number_format($sale->total_price, 0, ',', '.')); ?></h3>
</body>
</html><?php /**PATH C:\laragon\www\apotek33333\resources\views/pdf/struk.blade.php ENDPATH**/ ?>