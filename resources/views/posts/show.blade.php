<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('View Post') }}
            </h2>
            <a href="{{ route('posts.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded text-sm">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center">
                        <h1 class="text-2xl font-bold">{{ $post->title }}</h1>
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                            {{ $post->status ?? 'Draft' }}
                        </span>
                    </div>

                    <div class="mb-2 text-sm text-gray-500">
                        <span>Author: {{ $post->user->name }}</span>
                        <span class="mx-2">|</span>
                        <span>Posted: {{ $post->created_at->format('M d, Y H:i') }}</span>
                        @if($post->created_at != $post->updated_at)
                            <span class="mx-2">|</span>
                            <span>Updated: {{ $post->updated_at->format('M d, Y H:i') }}</span>
                        @endif
                    </div>

                    <div class="my-6">
                        {!! nl2br(e($post->content)) !!}
                    </div>

                    <div class="mt-6 flex space-x-2">
                        @can('update', $post)
                            <a href="{{ route('posts.edit', $post) }}" class="px-4 py-2 bg-yellow-500 text-white rounded">
                                Edit
                            </a>
                        @endcan

                        @can('delete', $post)
                            <form method="POST" action="{{ route('posts.destroy', $post) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded"
                                    onclick="return confirm('Are you sure you want to delete this post?')">
                                    Delete
                                </button>
                            </form>
                        @endcan

                        @if($post->status !== 'published')
                            @can('publish', $post)
                                <form method="POST" action="{{ route('posts.publish', $post) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">
                                        Publish
                                    </button>
                                </form>
                            @endcan
                        @endif

                        @if($post->status !== 'archived')
                            @can('archive', $post)
                                <form method="POST" action="{{ route('posts.archive', $post) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded">
                                        Archive
                                    </button>
                                </form>
                            @endcan
                        @endif

                        @if(session('success'))
                            <div class=" text-green-800 ">
                                {{ session('success') }}
                            </div>
                        @endif



                    </div>
                    <div class="mt-4 ml-2">Comments: </div>
                    @if($post->comments->count() > 0)
                        <div class="space-y-4 mb-6 mt-4">
                            @foreach($post->comments as $comment)
                                <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                    <div class="flex justify-between items-center mb-2">
                                        <div class="font-medium">{{ $comment->user->name }}</div>
                                        <div class="text-sm text-gray-500">
                                            {{ $comment->created_at->format('M d, Y H:i') }}
                                        </div>
                                    </div>
                                    <p class="text-gray-700 dark:text-gray-300">{{ $comment->content }}</p>

                                    @can('update', $comment)
                                        <div class="mt-2 flex space-x-2 justify-end text-sm">
                                            <a href="{{route('comments.edit', $comment->id)}}" class="text-indigo-600">Edit</a>

                                            @can('delete', $comment)
                                                <form method="POST" action="{{ route('comments.destroy', $comment) }}" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600"
                                                        onclick="return confirm('Delete this comment?')">Delete</button>
                                                </form>
                                            @endcan
                                        </div>
                                    @endcan
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 mb-6">No comments yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>