<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <?php echo e(__('Payments')); ?>

            </h2>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="container mx-auto">
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user-table', [])->html();
} elseif ($_instance->childHasBeenRendered('sP64wrT')) {
    $componentId = $_instance->getRenderedChildComponentId('sP64wrT');
    $componentTag = $_instance->getRenderedChildComponentTagName('sP64wrT');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('sP64wrT');
} else {
    $response = \Livewire\Livewire::mount('user-table', []);
    $html = $response->html();
    $_instance->logRenderedChild('sP64wrT', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        </div>
    </div>
 <?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?><?php /**PATH /Users/ehsanmody/Code/Maktab/services/old/maktabpayment/resources/views/payments/index.blade.php ENDPATH**/ ?>