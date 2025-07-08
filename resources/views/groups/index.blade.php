<h2>list group</h2>

<table>
    <thead>
        <th>Group name</th>
        <th>Action</th>
    </thead>
    <tbody>
        @foreach ($groups as $group)
            <tr>
                <td>{{$group->name}}</td>
                <td><a href="{{route('groups.user', $group->id)}}">Member</a></td>
            </tr>
        @endforeach
    </tbody>
</table>