<x-guest-layout>
    <section class="text-gray-600 body-font">
        <div class="container mx-auto flex flex-col px-5 py-24 justify-center items-center">
            <img class="lg:w-2/6 md:w-3/6 w-5/6 mb-10 object-cover object-center rounded" alt="hero"
                 src="{{ asset('svg/verify/completed.svg') }}">
            <div class="w-full md:w-2/3 flex flex-col mb-16 items-center text-center">
                <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">
                    تراکنش شماره
                    {{ $payment->id }}،
                    <span class="text-green-500">موفقیت آمیز</span>
                    بود.
                </h1>
                <p class="text-2xl mb-8 leading-relaxed">{{ $payment->logs()->latest()->first()->message }}</p>
                <p class="bg-blue-600 text-lg text-white p-4 rounded">
                    شماره ارجاع:
                    <span class="font-bold select-all">{{ $payment->logs()->latest()->first()->refID }}</span>
                </p>
            </div>
        </div>
    </section>
</x-guest-layout>
