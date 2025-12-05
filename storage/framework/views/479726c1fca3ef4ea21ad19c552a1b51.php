
<?php $__env->startSection('page_title', 'Receipt Details'); ?>
<?php $__env->startSection('content'); ?>

<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Receipt Details</h2>
            <div class="flex gap-2">
                <a href="<?php echo e(route('receipts.print', $receipt->id)); ?>" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Print Receipt
                </a>
                <a href="<?php echo e(route('receipts.index')); ?>" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                    Back to List
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="font-semibold text-lg mb-3 text-gray-700">Receipt Information</h3>
                <p class="mb-2"><strong>Receipt No:</strong> <?php echo e($receipt->unique_code); ?></p>
                <p class="mb-2"><strong>Receipt Date:</strong> <?php echo e($receipt->receipt_date ? $receipt->receipt_date->format('d-m-Y') : '-'); ?></p>
                <p class="mb-2"><strong>Company Name:</strong> <?php echo e($receipt->company_name); ?></p>
            </div>

            <div>
                <h3 class="font-semibold text-lg mb-3 text-gray-700">Payment Information</h3>
                <p class="mb-2"><strong>Received Amount:</strong> ₹<?php echo e(number_format($receipt->received_amount, 2)); ?></p>
                <p class="mb-2"><strong>Payment Type:</strong> <?php echo e($receipt->payment_type ?? '-'); ?></p>
                <p class="mb-2"><strong>Trans Code:</strong> <?php echo e($receipt->trans_code ?? '-'); ?></p>
            </div>
        </div>

        <?php if($receipt->narration): ?>
        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-3 text-gray-700">Narration</h3>
            <p class="text-gray-600"><?php echo e($receipt->narration); ?></p>
        </div>
        <?php endif; ?>

        <?php if($receipt->invoice_ids && count($receipt->invoice_ids) > 0): ?>
        <div class="mb-6">
            <h3 class="font-semibold text-lg mb-3 text-gray-700">Linked Invoices</h3>
            <table class="w-full border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left">Invoice No</th>
                        <th class="border border-gray-300 px-4 py-2 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $receipt->invoices(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2"><?php echo e($invoice->unique_code); ?></td>
                        <td class="border border-gray-300 px-4 py-2 text-right">₹<?php echo e(number_format($invoice->final_amount, 2)); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.macos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\GitVraj\HrPortal\resources\views/receipts/show.blade.php ENDPATH**/ ?>