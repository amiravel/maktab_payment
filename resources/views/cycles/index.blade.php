<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Cycles') }}
            </h2>

            <a class="py-2 px-4 capitalize tracking-wide bg-blue-600 dark:bg-gray-800 text-white font-medium rounded hover:bg-blue-500 dark:hover:bg-gray-700 focus:outline-none focus:bg-blue-500 dark:focus:bg-gray-700"
               href="{{ route('cycles.create') }}">{{ __('Create') }}</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:cycle-table />
        </div>
    </div>
</x-app-layout>
