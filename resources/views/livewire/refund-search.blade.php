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
    </div>

    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>#</th>
                <th>نام و نام خانوادگی</th>
                <th>ایمیل</th>
                <th>موبایل</th>
                <th>شماره ارجاع</th>
                <th>ساخته شده در</th>
                <th>آخرین بروزرسانی</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            @forelse($refunds as $index => $refund)
                <tr class="@if(!$refund->read) font-bold @endif">
                    <td>{{ $refund->id }}</td>
                    <td>{{ $refund->name }}</td>
                    <td class="select-all">{{ $refund->email }}</td>
                    <td class="select-all">{{ $refund->mobile }}</td>
                    <td class="select-all">{{ $refund->refID }}</td>

                    <td>{{ jdate($refund->created_at)->format('d M y - H:i') }}</td>
                    <td>{{ jdate($refund->updated_at)->format('d M y - H:i') }}</td>

                    <td>
                        <a href="{{ route('refunds.show', $refund) }}" class="btn btn--primary py-1">مشاهده</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">{{ __('No Results.') }}</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        {{ $refunds->links() }}
    </div>
</div>
