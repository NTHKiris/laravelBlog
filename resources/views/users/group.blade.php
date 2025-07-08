<h2>List group of user {{$user->name}}</h2>
<ul>
    @foreach ($user->groups as $group)
        <p>Group Name: {{$group->name}}</p>
        <li>{{$group->type}}</li>
        <li>{{$group->description}}</li>
        <li>{{$group->max_members}}</li>
        <li>{{($group->is_active) ? 'active' : 'offline'}}</li>
    @endforeach
</ul>