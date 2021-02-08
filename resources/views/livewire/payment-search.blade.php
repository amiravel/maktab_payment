<div class="space-y-8">
    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 space-y-4">
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-4">
                <label for="name" class="block text-sm font-medium text-gray-700">{{ __('Name') }}</label>
                <input type="text" name="name" id="name" autocomplete="name" wire:model.lazy="search.name"
                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div class="col-span-4">
                <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                <input type="email" name="email" id="email" autocomplete="email" wire:model.lazy="search.email"
                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>

            <div class="col-span-4">
                <label for="mobile" class="block text-sm font-medium text-gray-700">{{ __('Mobile') }}</label>
                <input type="tel" name="mobile" id="mobile" autocomplete="tel" wire:model.lazy="search.mobile"
                       class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            </div>
        </div>

        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-4">
                <label for="statuses" class="block text-sm font-medium text-gray-700">{{ __('Statuses') }}</label>
                <select id="statuses" name="statuses" multiple wire:model="search.statuses"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    {{--<option value="created">{{ __('Created') }}</option>--}}
                    <option value="successful">{{ __('Successful') }}</option>
                    <option value="error">{{ __('Error') }}</option>
                </select>
            </div>

            <div class="col-span-4">
                <label for="tags" class="block text-sm font-medium text-gray-700">{{ __('Tags') }}</label>
                <select id="tags" name="tags" wire:model="search.tags" multiple
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-span-4 grid grid-flow-row gap-6">
                <div>
                    <label for="drive" class="block text-sm font-medium text-gray-700">{{ __('Drive') }}</label>
                    <select id="drive" name="drive" wire:model="search.drive"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">{{ __('All') }}</option>
                        @foreach($drives as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-flow-col auto-cols-auto gap-6">
                    <div>
                        <label for="from" class="block text-sm font-medium text-gray-700">{{ __('From') }}</label>
                        <input type="datetime-local" name="from" id="from" wire:model.lazy="search.from"
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label for="to" class="block text-sm font-medium text-gray-700">{{ __('To') }}</label>
                        <input type="datetime-local" name="to" id="to" wire:model.lazy="search.to"
                               class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>نام و نام خانوادگی</th>
                <th>ایمیل</th>
                <th>موبایل</th>
                <th>مبلغ</th>
                <th>ساخته شده در</th>
                <th>آخرین بروزرسانی</th>
                {{--<th>ساخته شده</th>--}}
                <th>پرداخت</th>
                <th>خطا</th>
                <th>درگاه</th>
                <th>تگ‌ها</th>
                <th>شماره ارجاع</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @forelse($payments as $index => $payment)
                <tr class="@if(!$payment->read) font-bold @endif"
                    onclick="toggleRow(this)">
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->name }}</td>
                    <td class="select-all">{{ $payment->email }}</td>
                    <td class="select-all">{{ $payment->mobile }}</td>
                    <td>{{ number_format($payment->amount) }}</td>
                    <td>{{ jdate($payment->created_at)->format('d M y - H:i') }}</td>
                    <td>{{ jdate($payment->updated_at)->format('d M y - H:i') }}</td>
                    {{--<td>
                        <x-payment-status-icon :status="$payment->status('created')"/>
                    </td>--}}
                    <td>
                        <x-payment-status-icon :status="$payment->status('successful')"/>
                    </td>
                    <td>
                        <x-payment-status-icon :status="$payment->status('error')"/>
                    </td>
                    <td>
                        <x-payment-drive-icon :drive="$payment->drive"/>
                    </td>
                    <td>
                        {{ $payment->tags->implode('name', ',') }}
                    </td>
                    <td class="select-all">{{ $payment->referenceID }}</td>
                    <td>
                        <a href="{{ route('payments.show', $payment) }}" class="btn btn--primary">مشاهده</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="14">{{ __('No Results.') }}</td>
                </tr>
            @endforelse
            </tbody>
            <tfoot>
            <td>{{ $payments->count() }}</td>
            <td colspan="3"></td>
            <td>{{ number_format($payments->sum('amount')) }}</td>
            <td colspan="9"></td>
            </tfoot>
        </table>

        {{ $payments->links() }}
    </div>
</div>
