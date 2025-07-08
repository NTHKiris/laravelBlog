<h2>List book of {{$author->name}}</h2>
<ul>
    @foreach ($author->books as $book)
        <li>{{$book->name}}</li>
    @endforeach
</ul>