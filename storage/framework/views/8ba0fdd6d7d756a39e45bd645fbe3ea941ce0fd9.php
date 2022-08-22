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
        <input type="hidden" name="status" value="0">
        <input type="hidden" name="message" value="<?php echo e($payment->logs()->latest()->first()->message ?? $message); ?>">
    </form>
    <?php endif; ?>
    <section class="text-gray-600 body-font">
        <div class="container mx-auto flex flex-col px-5 py-12 justify-center items-center">
            <img class="lg:w-2/6 md:w-3/6 w-5/6 mb-10 object-cover object-center rounded" alt="hero" src="<?php echo e(asset('svg/verify/no-data.svg')); ?>">
            <div class="w-full md:w-2/3 flex flex-col items-center text-center">
                <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">
                    تراکنش شماره
                    <span class="select-all"><?php echo e($payment->id); ?></span>،
                    <span class="text-red-500">ناموفق</span>
                    بود.
                </h1>
                <p class="text-2xl mb-8 leading-relaxed"><?php echo e($payment->logs()->latest()->first()->message ?? $message); ?></p>

                <a href="<?php echo e($payment->callback); ?>" class="py-2 px-4 flex justify-center items-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-500 focus:ring-offset-blue-200 text-white transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                    </svg>

                    بازگشت به فرم پرداخت
                </a>

                <div class="bg-lightblue pt-20 px-4">
                    <div class="mx-auto max-w-6xl flex flex-col md:flex-row">
                        <h2 class="md:mr-8 mr-0 md:mb-0 mb-8 w-full md:w-1/3 text-3xl font-extrabold leading-9">
                            راهنما
                        </h2>
                        <dl class="w-full md:w-2/3">
                            <dt class="mb-4">
                                <h3 class="text-xl font-semibold">
                                    پول از حساب من کسر شد اما پرداخت موفقیت آمیز نشد.
                                </h3>
                            </dt>
                            <dd class="mb-16">
                                <p>
                                    در صورتی که پول از حساب شما کسر شده است و به شما پیام ناموفق نمایش داده شده است،
                                    مبلغ پرداخت شده ظرف چند ساعت به حساب شما باز میگردد و می‌توانید مجددا عملیات پرداخت
                                    را انجام دهید.
                                </p>
                            </dd>
                            <dt class="mb-4">
                                <h3 class="text-xl font-semibold">
                                    پول از حساب من کسر شده و هنوز برگشت نخورده است.
                                </h3>
                            </dt>
                            <dd class="">
                                <p>
                                    عملیات بازگشت پرداخت معمولا بین ۲۴ تا ۷۲ ساعت زمان می‌برد، اما در صورتی که ظرف چند
                                    ساعت این اتفاق صورت نگرفت <strong>شماره تراکنش</strong> را به پشتیبانی مکتب شریف ارائه کنید تا
                                    پیگیری‌های لازم انجام شود.
                                </p>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal12189013e9e6252be6531784188be5bbf232d310)): ?>
<?php $component = $__componentOriginal12189013e9e6252be6531784188be5bbf232d310; ?>
<?php unset($__componentOriginal12189013e9e6252be6531784188be5bbf232d310); ?>
<?php endif; ?><?php /**PATH /Users/ehsanmody/Code/Maktab/services/old/maktabpayment/resources/views/verify/failed.blade.php ENDPATH**/ ?>