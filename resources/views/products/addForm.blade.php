<form action="{{route('products.store')}}" method="POST">
    @csrf
    <div>
        <label>Name: </label>
        <input type="text" name = "name" placeholder="type product name" > 
        <br>
        <label>Category: </label>
        <input type="text" name = "category" placeholder="type category" > 
        <br>
        <label>Price: </label>
        <input type="number" name = "price" placeholder="type price" > 
        <br>
        <label>Description: </label>
        <input type="text" name = "description" placeholder="type description" > 
        <br>
    </div>
    <button type="submit">Save</button>
</form>