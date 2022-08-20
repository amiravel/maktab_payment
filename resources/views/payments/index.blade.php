<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Payments') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="container mx-auto">
            <livewire:payment-table />
        </div>
    </div>
</x-app-layout>