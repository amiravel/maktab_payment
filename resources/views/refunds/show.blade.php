<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Refund') }} #{{ $refund->id }}
            </h2>

            <a class="py-2 px-4 capitalize tracking-wide bg-blue-600 dark:bg-gray-800 text-white font-medium rounded hover:bg-blue-500 dark:hover:bg-gray-700 focus:outline-none focus:bg-blue-500 dark:focus:bg-gray-700"
               href="{{ route('refunds.index') }}">{{ __('Back') }}</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            @if($payment->drive->value == 'vandar')
                <div class="flex w-full mx-auto overflow-hidden bg-white rounded-lg shadow-md">
                    <div class="flex items-center justify-center w-12 bg-gray-500">
                        <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40"
                             xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z"/>
                        </svg>
                    </div>

                    <div class="px-4 py-2 -mx-3 flex flex-1 justify-between items-center">
                        <div class="mx-3">
                            <span class="font-semibold text-grey-500 dark:text-green-400">عودت خودکار</span>
                            <p class="text-sm text-gray-600 dark:text-gray-200">اگر پرداختی از درگاه وندار انجام شده
                                باشد
                                امکان عودت خودکار را دارید.</p>
                        </div>

                        <button disabled
                           class="mx-3 py-2 px-4 capitalize tracking-wide bg-gray-600 dark:bg-gray-800 text-white font-medium rounded hover:bg-gray-500 dark:hover:bg-gray-700 focus:outline-none focus:bg-gray-500 dark:focus:bg-gray-700">
                            ثبت درخواست (غیرفعال)
                        </button>
                    </div>
                </div>
            @endif

            <div class="space-y-4">
                @if($payment)
                    <div class="flex w-full mx-auto overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div class="flex items-center justify-center w-12 bg-green-500">
                            <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z"/>
                            </svg>
                        </div>

                        <div class="px-4 py-2 -mx-3">
                            <div class="mx-3">
                            <span
                                class="font-semibold text-green-500 dark:text-green-400">تراکنش یافت شد.</span>
                                <p class="text-sm text-gray-600 dark:text-gray-200">تراکنش کاربر در سیستم یافت شده
                                    است.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex w-full mx-auto overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div class="flex items-center justify-center w-12 bg-blue-500">
                            <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z"/>
                            </svg>
                        </div>

                        @if(is_string($mask_card_number))
                            <div class="px-4 py-2 -mx-3 w-full">
                                <div class="mx-3">
                                    @if(\Illuminate\Support\Str::is($mask_card_number, implode("-", str_split($refund->card_number, 4))))
                                        <span class="font-semibold text-blue-500 dark:text-blue-400">تطبیق شماره کارت صحیح است.</span>
                                    @else
                                        <span class="font-semibold text-red-500 dark:text-red-400">تطبیق شماره کارت غلط است.</span>
                                    @endif

                                    <ul class="flex flex-row mt-2 space-x-2 space-x-reverse">
                                        <li class="border-gray-400 flex flex-row w-full">
                                            <div
                                                class="shadow border select-none cursor-pointer bg-white dark:bg-gray-800 rounded-md flex flex-1 items-center p-4">
                                                <div class="flex-1">
                                                    <div class="font-medium dark:text-white">
                                                        شماره کارت موجود در عودت
                                                    </div>
                                                    <div
                                                        class="text-gray-600 dark:text-gray-200 text-sm">{{ implode("-", str_split($refund->card_number, 4)) }}</div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="border-gray-400 flex flex-row w-full">
                                            <div
                                                class="shadow border select-none cursor-pointer bg-white dark:bg-gray-800 rounded-md flex flex-1 items-center p-4">
                                                <div class="flex-1">
                                                    <div class="font-medium dark:text-white">
                                                        شماره کارت ماسک شده
                                                    </div>
                                                    <div class="text-gray-600 dark:text-gray-200 text-sm"
                                                         style="direction: ltr;">{{ $mask_card_number }}</div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @else
                            <div class="px-4 py-2 -mx-3">
                                <div class="mx-3">
                                    <span
                                        class="font-semibold text-blue-500 dark:text-blue-400">شماره کارت ماسک شده</span>
                                    <p class="text-sm text-gray-600 dark:text-gray-200">شماره کارت ماسک شده‌ای در سیستم
                                        موجود نیست.</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="flex w-full mx-auto overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div class="flex items-center justify-center w-12 bg-red-500">
                            <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z"/>
                            </svg>
                        </div>

                        <div class="px-4 py-2 -mx-3">
                            <div class="mx-3">
                                <span class="font-semibold text-red-500 dark:text-red-400">تراکنش یافت نشد.</span>
                                <p class="text-sm text-gray-600 dark:text-gray-200">تراکنشی با توجه به اطلاعاتی که کاربر
                                    در درخواست وارد کرده است یافت نشده است.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Refund Details
                    </h3>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        @foreach($refund->makeHidden(['id', 'uuid', 'seen', 'deleted_at'])->attributesToArray() as $key => $value)
                            <div
                                class="@if ($loop->odd) bg-gray-50 @else bg-white @endif px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">
                                    {{ __(\Illuminate\Support\Str::studly($key)) }}
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $value }}
                                </dd>
                            </div>
                        @endforeach
                    </dl>
                </div>
            </div>

            <div class="bg-white shadow-xl overflow-hidden sm:rounded-lg">

                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Refund Payment
                    </h3>
                </div>

                <div class="space-y-8">
                    @if($payment)
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                                <h4 class="text-base leading-6 font-medium text-gray-900">
                                    {{ sprintf("Payment #%s", $payment->id) }}
                                </h4>

                                <a class="py-2 px-4 capitalize tracking-wide bg-blue-600 dark:bg-gray-800 text-white font-medium rounded hover:bg-blue-500 dark:hover:bg-gray-700 focus:outline-none focus:bg-blue-500 dark:focus:bg-gray-700"
                                   href="{{ route('payments.show', $payment) }}" target="_blank">
                                    {{ __('View') }} {{ __('Payment') }}
                                </a>
                            </div>
                            <div class="border-t border-gray-200">
                                <dl>
                                    @foreach($payment->makeHidden(['id', 'user_id', 'drive_id', 'information', 'callback', 'read', 'created_at', 'updated_at'])->attributesToArray() as $key => $value)
                                        <div
                                            class="@if($refund->$key == $value) bg-green-50 @elseif($loop->odd) bg-gray-50 @else bg-white @endif px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">
                                                {{ __(\Illuminate\Support\Str::studly($key)) }}
                                            </dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{ $value }}
                                            </dd>
                                        </div>
                                    @endforeach

                                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">
                                            {{ __('Drive') }}
                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $payment->drive->name }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    @else
                        <p class="px-4 py-5 sm:px-6">تراکنشی یافت نشده است.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
