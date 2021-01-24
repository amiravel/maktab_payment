<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('tags.update', $tag) }}" method="post">
                    @csrf
                    @method('PATCH')

                    <div class="mt-4">
                        <label for="parent" class="text-gray-700 dark:text-gray-200">{{ __('Parent') }}</label>
                        <select name="parent" id="parent"
                                class="mt-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded py-2 px-4 block w-full focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                            <option value="">-- {{ __('No Parent') }} --</option>
                            @foreach($tags as $key => $value)
                                <option value="{{ $key }}" @if($key == $tag->parent) selected @endif>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <label for="name" class="text-gray-700 dark:text-gray-200">{{ __('Name') }}</label>
                        <input type="text" value="{{ old('name', $tag->name) }}"
                               class="mt-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded py-2 px-4 block w-full focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"
                               id="name" name="name" required>
                    </div>

                    <div class="mt-4">
                        <label for="drive" class="text-gray-700 dark:text-gray-200">{{ __('Drive') }}</label>
                        <select name="drive_id" id="drive"
                                class="mt-2 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 rounded py-2 px-4 block w-full focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                            <option value="">-- {{ __('No Drive') }} --</option>
                            @foreach($drives as $key => $value)
                                <option value="{{ $key }}" @if($tag->drive()->first(['id']) == $key) selected @endif>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit"
                                class="bg-gray-700 text-white py-2 px-4 rounded hover:bg-gray-600 focus:outline-none focus:bg-gray-600">
                            {{ __('Update') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
