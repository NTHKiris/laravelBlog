<h2>List of books</h2>
<a href="{{route('books.create')}}">Add new book</a>
@if (isset($books) && $books->count() > 0)
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Price</th>
                <th>Description</th>
                <th>Author</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $book)
                <tr>
                    <td>{{$book->id}}</td>
                    <td>{{$book->name}}</td>
                    <td>{{$book->type}}</td>
                    <td>{{$book->price}}</td>
                    <td>{{ Str::limit($book->description, 100)}}</td>
                    <td>{{$book->author->name}}</td>
                    <td>
                        <a href="{{route('books.show', $book->id)}}">View</a>
                        <a href="{{route('books.edit', $book->id)}}">Edit</a>
                        <form action="{{route('books.destroy', $book->id)}}" method="POST" style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h2>Not found </h2>
@endif