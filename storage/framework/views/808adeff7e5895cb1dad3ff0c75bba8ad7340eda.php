<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> -->

    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo e(mix('css/app.css')); ?>">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
</head>

<body dir="rtl">
    <div class="w-1/2 mx-auto mt-8">
        <div class="p-4 mb-4 text-lg text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800 flex justify-between items-center" role="alert">
            <div>در حال انتقال تا <span id="countdown" class="font-medium">30</span> ثانیه دیگر!</div>

            <button type="button" class="py-2.5 px-5 mr-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" onclick="submitForm()">
                بازگشت به سایت
            </button>
        </div>
    </div>

    <div class="font-sans text-gray-900 antialiased">
        <?php echo e($slot); ?>

    </div>

    <script>
        var seconds = 30;

        let countdown = setInterval(() => {
            seconds--;
            document.getElementById('countdown').innerText = seconds;

            if (seconds === 0) {
                clearInterval(countdown);
                submitForm();
            }
        }, 1000);

        function submitForm() {
            document.forms[0].submit();
        }
    </script>
</body>

</html><?php /**PATH /Users/ehsanmody/Code/Maktab/services/old/maktabpayment/resources/views/layouts/verify.blade.php ENDPATH**/ ?>