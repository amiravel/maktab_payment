<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('tags.store') }}" method="post" x-data="{ parent: '', new_drive: false }">
                    @csrf

                    <div class="mt-4">
                        <label for="name" class="text-gray-700 dark:text-gray-200">{{ __('Parent') }}</label>
                        <select name="parent" id="parent"
                                class="mt-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded py-2 px-4 block w-full focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                                x-model="parent">
                            <option value="">-- {{ __('No Parent') }} --</option>
                            @foreach($tags as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <template x-if="parent !== ''">
                        <fieldset class="mt-4 border p-4 b-6">
                            <legend class="bg-white text-lg text-gray-700 dark:text-white font-semibold capitalize px-4">
                                {{ __('Drive') }}
                            </legend>

                            <div>
                                <input type="checkbox" id="new_drive" x-model="new_drive" />
                                <label for="new_drive">New Drive</label>
                            </div>

                            <template x-if="new_drive === false">
                                <div class="mt-4">
                                    <label for="drive[id]" class="text-gray-700 dark:text-gray-200">{{ __('Drives') }}</label>
                                    <select name="drive[id]" id="drive[id]"
                                            class="mt-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded py-2 px-4 block w-full focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                                        @foreach($drives as $drive)
                                            <option value="{{ $drive->id }}">{{ $drive->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </template>
                            <template x-if="new_drive === true">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                                    <div>
                                        <label for="drive[name]" class="text-gray-700 dark:text-gray-200">
                                            {{ __('Name') }}
                                        </label>

                                        <input name="drive[name]" id="drive[name]" class="mt-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded py-2 px-4 block w-full focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" required />
                                    </div>

                                    <div>
                                        <label for="drive[value]" class="text-gray-700 dark:text-gray-200">
                                            {{ __('Value') }}
                                        </label>

                                        <input name="drive[value]" id="drive[value]" class="mt-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded py-2 px-4 block w-full focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" required />
                                    </div>
                                </div>
                            </template>
                        </fieldset>
                    </template>

                    <div class="mt-4">
                        <label for="name" class="text-gray-700 dark:text-gray-200">{{ __('Name') }}</label>
                        <input type="text"
                               class="mt-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded py-2 px-4 block w-full focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                               id="name" name="name" required>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit"
                                class="bg-gray-700 text-white py-2 px-4 rounded hover:bg-gray-600 focus:outline-none focus:bg-gray-600">
                            {{ __('Create') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
