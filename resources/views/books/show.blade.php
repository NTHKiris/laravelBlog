<h2>Book Detail: {{$book->name}}</h2>
<ul>
    <li>Book name: {{$book->name}}</li>
    <li>Type: {{$book->type}}</li>
    <li>Price: {{$book->price}}</li>
    <li>Description: {{$book->description}}</li>
    <li>Author: {{$book->author->name}}</li>

</ul>
<a href="{{route('books.index')}}"> return</a>