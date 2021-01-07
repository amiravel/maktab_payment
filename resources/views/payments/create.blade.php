<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('payments.store') }}" method="post">
                    @csrf

                    <input type="hidden" name="callback" value="{{ env('APP_URL') }}">

                    <fieldset>
                        <legend class="text-lg text-gray-700 dark:text-white font-semibold capitalize">
                            {{ __('Information') }}
                        </legend>
                        <div class="mt-4">
                            <label for="name" class="text-gray-700 dark:text-gray-200">{{ __('Name') }} *</label>
                            <input type="text"
                                   class="mt-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded py-2 px-4 block w-full focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                   id="name" name="name" required>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                            <div>
                                <label for="email" class="text-gray-700 dark:text-gray-200">{{ __('Email') }}</label>
                                <input type="email"
                                       class="mt-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded py-2 px-4 block w-full focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                       id="email" name="email">
                            </div>
                            <div>
                                <label for="mobile" class="text-gray-700 dark:text-gray-200">{{ __('Mobile') }}</label>
                                <input type="text"
                                       class="mt-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded py-2 px-4 block w-full focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                       id="mobile" name="mobile">
                            </div>
                        </div>

                        <div class="mt-4">
                            <label for="description" class="text-gray-700 dark:text-gray-200">
                                {{ __('Description') }} *
                            </label>
                            <textarea name="description" id="description"
                                      class="mt-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded py-2 px-4 block w-full focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                      rows="4"
                                      required></textarea>
                        </div>
                    </fieldset>

                    <fieldset class="mt-4">
                        <legend class="text-lg text-gray-700 dark:text-white font-semibold capitalize">
                            {{ __('Tags') }}
                        </legend>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                            @foreach($tags as $index => $parent)
                                <div>
                                    <label for="{{ $parent->id }}" class="text-gray-700 dark:text-gray-200">
                                        {{ $parent->name }}
                                    </label>

                                    <select name="tags[]" id="{{ $parent->id }}"
                                            class="mt-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded py-2 px-4 block w-full focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                                        <option value="" selected disabled hidden></option>
                                        @foreach($parent->children as $jndex => $tag)
                                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                        </div>
                    </fieldset>

                    <div class="mt-4">
                        <label for="amount" class="text-gray-700 dark:text-gray-200">{{ __('Amount') }} *</label>
                        <input type="number" min="5000"
                               class="mt-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded py-2 px-4 block w-full focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                               id="amount" aria-describedby="amountHelp"
                               name="amount" required>
                        <small id="amountHelp" class="form-text text-muted">
                            {{ __('Enter the amount in Tomans.') }}
                        </small>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit"
                                class="bg-gray-700 text-white py-2 px-4 rounded hover:bg-gray-600 focus:outline-none focus:bg-gray-600">
                            {{ __('Pay') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
