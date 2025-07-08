<h2>User of group {{$group->name}}</h2>
@if ($group->users->count() > 0)
    <ul>
        @foreach ($group->users as $user)
            <li>{{$user->name}}</li>
        @endforeach
    </ul>
@else
    <p>Group don't have member</p>
@endif