<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, [] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <?php echo e(__('Cycles')); ?>

            </h2>

            <a class="py-2 px-4 capitalize tracking-wide bg-blue-600 dark:bg-gray-800 text-white font-medium rounded hover:bg-blue-500 dark:hover:bg-gray-700 focus:outline-none focus:bg-blue-500 dark:focus:bg-gray-700" href="<?php echo e(route('cycles.create')); ?>"><?php echo e(__('Create')); ?></a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="container mx-auto">
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('cycle-table', [])->html();
} elseif ($_instance->childHasBeenRendered('ndvSDT1')) {
    $componentId = $_instance->getRenderedChildComponentId('ndvSDT1');
    $componentTag = $_instance->getRenderedChildComponentTagName('ndvSDT1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('ndvSDT1');
} else {
    $response = \Livewire\Livewire::mount('cycle-table', []);
    $html = $response->html();
    $_instance->logRenderedChild('ndvSDT1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH /Users/ehsanmody/Code/Maktab/services/old/maktabpayment/resources/views/cycles/index.blade.php ENDPATH**/ ?>