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
                        Refund Payments
                    </h3>
                </div>

                <div class="space-y-8">
                    @forelse($payments as $payment)
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
                                    @foreach($payment->makeHidden(['id', 'user_id', 'information', 'callback', 'read', 'created_at', 'updated_at'])->attributesToArray() as $key => $value)
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
                                </dl>
                            </div>
                        </div>
                    @empty
                        <p>تراکنشی بر اساس شماره ارجاع یافت نشد.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
