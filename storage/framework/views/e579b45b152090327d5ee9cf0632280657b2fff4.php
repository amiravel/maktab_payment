<?php if (isset($component)) { $__componentOriginal12189013e9e6252be6531784188be5bbf232d310 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\VerifyLayout::class, [] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('verify-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\VerifyLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php if($payment->extra_callback): ?>
    <form method="POST" action="<?php echo e($payment->extra_callback); ?>">
        <input type="hidden" name="status" value="1">
        <input type="hidden" name="message" value="<?php echo e($payment->logs()->latest()->first()->message); ?>">
    </form>
    <?php endif; ?>
    <section class="text-gray-600 body-font">
        <div class="container mx-auto flex flex-col px-5 py-12 justify-center items-center">
            <img class="lg:w-2/6 md:w-3/6 w-5/6 mb-10 object-cover object-center rounded" alt="hero" src="<?php echo e(asset('svg/verify/completed.svg')); ?>">
            <div class="w-full md:w-2/3 flex flex-col mb-16 items-center text-center">
                <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">
                    تراکنش شماره
                    <?php echo e($payment->id); ?>،
                    <span class="text-green-500">موفقیت آمیز</span>
                    بود.
                </h1>
                <p class="text-2xl mb-8 leading-relaxed"><?php echo e($payment->logs()->latest()->first()->message); ?></p>
                <p class="bg-blue-600 text-lg text-white p-4 rounded">
                    شماره ارجاع:
                    <span class="font-bold select-all"><?php echo e($payment->logs()->latest()->first()->refID); ?></span>
                </p>
            </div>
        </div>
    </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal12189013e9e6252be6531784188be5bbf232d310)): ?>
<?php $component = $__componentOriginal12189013e9e6252be6531784188be5bbf232d310; ?>
<?php unset($__componentOriginal12189013e9e6252be6531784188be5bbf232d310); ?>
<?php endif; ?><?php /**PATH /Users/ehsanmody/Code/Maktab/services/old/maktabpayment/resources/views/verify/success.blade.php ENDPATH**/ ?>