<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto ">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        @can('create', App\Models\Post::class)
                            <a href="{{ route('posts.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">Add New
                                Post</a>
                        @endcan
                    </div>

                    @if(isset($posts) && $posts->count() > 0)
                        <table>
                            <thead>
                                <tr>
                                    <th class="px-6 py-3  bg-gray-50 text-left text-xm font-medium text-gray-500 ">
                                        Title</th>
                                    <th class="px-6 py-3  bg-gray-50 text-left text-xm font-medium text-gray-500 ">
                                        Author</th>
                                    @can('viewAny', App\Models\Post::class)
                                        <th class="px-6 py-3  bg-gray-50 text-left text-xm font-medium text-gray-500 ">
                                            Status</th>
                                    @endcan
                                    <th class="px-6 py-3  bg-gray-50 text-left text-xm font-medium text-gray-500 ">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($posts as $post)
                                    @can('view', $post)
                                        <tr>
                                            <td class="px-6 py-3 ">{{ $post->title }}
                                            </td>
                                            <td class="px-6 py-3 ">
                                                {{ $post->user->name }}
                                            </td>
                                            @can('viewAny', App\Models\Post::class)
                                                <td class="px-6 py-3 ">
                                                    {{ $post->status ?? 'Draft' }}
                                                </td>
                                            @endcan
                                            <td class="px-6 py-3 ">
                                                @can('view', $post)
                                                    <a href="{{ route('posts.show', $post->id) }}" class="text-blue-600">View</a>
                                                @endcan
                                                @can('update', $post)
                                                    <a href="{{ route('posts.edit', $post->id) }}" class=" text-indigo-600">Edit</a>
                                                @endcan
                                                @can('delete', $post)
                                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class=" text-red-600 "
                                                            onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                                                    </form>
                                                @endcan
                                                @if($post->status !== 'published')
                                                    @can('publish', $post)
                                                        <form action="{{ route('posts.publish', $post->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class=" text-green-600 ">Publish</button>
                                                        </form>
                                                    @endcan
                                                @endif
                                            </td>
                                        </tr>
                                    @endcan
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No posts found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>