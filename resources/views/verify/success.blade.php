<x-guest-layout>
    <section class="text-gray-600 body-font">
        <div class="container mx-auto flex px-5 py-12 md:flex-row flex-col items-center">
            <div
                class="lg:flex-grow md:w-1/2 lg:pe-24 md:pe-16 flex flex-col md:items-start md:text-start mb-16 md:mb-0 items-center text-center">
                <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">
                    {{ sprintf('نتیجه تراکنش #%s', $payment->id) }}
                    <br class="hidden lg:inline-block">موفق
                </h1>
                <p class="mb-2 leading-relaxed">{{ $payment->logs()->latest()->first()->message }}</p>
                <p class="mb-8 leading-relaxed text-gray-400">
                    {{ sprintf('شماره پیگیری: %s', $payment->logs()->latest()->first()->refID) }}
                </p>
                <div class="flex justify-center">
                    <a href="https://maktabsharif.ir"
                        class="inline-flex text-white bg-green-500 border-0 py-2 px-6 focus:outline-none hover:bg-green-600 rounded text-lg">
                        وبسایت مکتب شریف
                    </a>
                </div>
            </div>
            <div class="lg:max-w-lg lg:w-full md:w-1/2 w-5/6">
                <img class="object-cover object-center" alt="No Data" src="{{ asset('svg/verify/completed.svg') }}">
            </div>
        </div>
    </section>
</x-guest-layout>
