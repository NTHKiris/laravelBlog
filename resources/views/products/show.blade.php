<h2>{{$product->name}}</h2>

<ul>
    <li>Category: {{$product->category}}</li>
    <li>Price: {{"$" .  $product->price}}</li>
    <li>Description: {{$product->description}}</li>
</ul>