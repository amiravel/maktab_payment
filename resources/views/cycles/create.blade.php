<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create') }} {{ __('Cycle') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            @if($errors->any())
                <div class="bg-red-500 overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <ol class="list-decimal">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ol>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('cycles.store') }}" method="post" class="space-y-4">
                    @csrf

                    <label class="block">
                        <span class="text-gray-700">{{ __('First') }}</span>
                        <input type="number" class="form-input mt-1 block w-full" name="first" step="1000000" required>
                    </label>

                    <label class="block">
                        <span class="text-gray-700">{{ __('Center') }}</span>
                        <input type="number" class="form-input mt-1 block w-full" name="center" step="1000000">
                    </label>

                    <label class="block">
                        <span class="text-gray-700">{{ __('End') }}</span>
                        <input type="number" class="form-input mt-1 block w-full" name="end" step="1000000" required>
                    </label>

                    <label class="block">
                        <span class="text-gray-700">{{ __('Percentage') }}</span>
                        <input type="number" class="form-input mt-1 block w-full" name="percentage" min="1" max="100"
                               required>
                    </label>

                    <button type="submit"
                            class="bg-gray-700 text-white py-2 px-4 rounded hover:bg-gray-600 focus:outline-none focus:bg-gray-600">
                        {{ __('Create') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
