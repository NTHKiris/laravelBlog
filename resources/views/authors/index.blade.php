<h2>list Author</h2>

<table>
    <thead>
        <th>Book name</th>
        <th>Action</th>
    </thead>
    <tbody>
        @foreach ($authors as $author)
            <tr>
                <td>{{$author->name}}</td>
                <td><a href="{{route('authors.show', $author->id)}}">list books</a></td>
            </tr>
        @endforeach
    </tbody>
</table>