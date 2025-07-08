<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit comment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{route('comments.update', $comment->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <x-input-label for="content">Comment</x-input-label>
                        <textarea name="content" id="content"
                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm " rows="10">
                            {{old('content', $comment->content)}}
                        </textarea>
                        <x-input-error :messages="$errors->get('content')" />
                        <div class="mt-4 flex items-center justify-end">
                            <x-secondary-button class="mr-2" onclick="window.history.back()">
                                {{ __('Cancel') }}
                            </x-secondary-button>
                            <x-primary-button>
                                {{ __('Save') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>