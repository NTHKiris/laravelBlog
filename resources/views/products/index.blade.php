<h2>List products</h2>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Description</th>
        </tr>
    </thead>
    <body>
        @foreach ($products as $product)
            <tr>
                <td>{{$product->name}}</td>
                <td>{{$product->category}}</td>
                <td>{{"$" . $product->price}}</td>
                <td>{{$product->description}}</td>
                <td><a href="{{route('products.show',$product->id)}}">Detail</a></td>
                <td><a href="{{route('products.edit',$product->id)}}">Edit</a></td>
                <td>
                    <form action="{{route('products.destroy', $product->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </body>

</table>