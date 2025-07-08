{{--
<pre>{{ json_encode($user, JSON_PRETTY_PRINT) }}

</pre> --}}
{{-- <p>{{Auth::id()}}</p> --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users Page') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto ">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mb-4">
                        <a href="{{route('users.create')}} " class="px-4 py-2 bg-blue-500 text-white rounded">Create
                            User</a>
                    </div>
                    @if (isset($users) && $users->count() > 0)
                        <table>
                            <thead>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="p-2">{{$user->name}}</td>
                                        <td class="p-2">{{$user->email}}</td>
                                        <td class="p-2">
                                            <a href="{{route('users.edit', $user->id)}}" class="text-blue-500">Edit</a>
                                            <form action="{{route('users.destroy', $user->id)}}" method="POST"
                                                class="inline-block text-red-600 ">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">Delete</button>
                                            </form>
                                            <a href="{{route('users.profile', $user->id)}}" class="text-green-500">Profile</a>
                                            <a href="{{route('users.groups', $user->id)}}" class="text-yellow-500">Groups</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else

                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>