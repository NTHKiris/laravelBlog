<h2>Edit product</h2>
<form action="{{route('products.update', $product->id)}}" method="POST">
    @csrf
    @method('PUT')
    <label>Name:</label>
    <input type="text" name="name" value="{{old('name',$product->name)}}">
    <label>Category:</label>
    <input type="text" name="category" value="{{old('category',$product->category)}}">
    <label>Price:</label>
    <input type="number" name="price" value="{{old('price',$product->price)}}">
    <label>Description</label>
    <input type="text" name="description" value="{{old('description',$product->description)}}">
    <button type="submit">Save</button>
</form>