<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ sprintf("Payment #%s", $payment->id) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="space-x-3">
                @foreach($payment->tags as $tag)
                    <span class="inline-block rounded-full text-white bg-indigo-500 px-2 py-1 text-xs font-bold">
                        {{ $tag->name }}
                    </span>
                @endforeach
            </div>

            <div class="space-x-3">
                <span class="inline-block rounded-full text-white bg-indigo-500 px-2 py-1 text-xs font-bold">
                    {{ $tag->drive->name }}
                </span>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Payment Details
                    </h3>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        @foreach($payment->makeHidden(['id', 'user_id', 'callback'])->attributesToArray() as $key => $value)
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

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Payment Logs
                    </h3>
                </div>
                <div class="border-t border-gray-200">
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                        <tr>
                                            @foreach((new \App\Models\PaymentLog)->makeHidden(['id', 'payment_id', 'updated_at'])->toArray() as $key => $value)
                                                <th scope="col"
                                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    {{ $key }}
                                                </th>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($payment->logs as $log)
                                            <tr>
                                                @foreach($log->makeHidden(['id', 'payment_id', 'updated_at'])->toArray() as $key => $value)
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $value }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @empty
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    No Logs.
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
