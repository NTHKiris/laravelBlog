<h2>Add a book</h2>
<form action="{{route('books.store')}}" method="POST">
    @csrf
    
    <div>
        <label>Name:</label>
        <input type="text" name="name" placeholder="Enter book name" value="{{old('name')}}" >
        @error('name')
            <span style="color: red">{{ $message }}</span>
        @enderror
    </div>
    
    <div>
        <label>Type:</label>
        <select name="type" >
            <option value="">Select type</option>
            <option value="novel" {{old('type') == 'novel' ? 'selected' : ''}}>Novel</option>
            <option value="manga" {{old('type') == 'manga' ? 'selected' : ''}}>Manga</option>
            <option value="science" {{old('type') == 'science' ? 'selected' : ''}}>Science</option>
            <option value="news" {{old('type') == 'news' ? 'selected' : ''}}>News</option>
            <option value="document" {{old('type') == 'document' ? 'selected' : ''}}>Document</option>
        </select>
    </div>
    
    <div>
        <label>Price:</label>
        <input type="number" name="price" placeholder="Enter price" value="{{old('price')}}" >
       
    </div>
    
    <div>
        <label>Description:</label>
        <textarea name="description" placeholder="Enter description" rows="4">{{old('description')}}</textarea>
       
    </div>
    
    <div>
        <label>Author:</label>
        <select name="author_id">
            <option value="">Select author</option>
            @foreach(\App\Models\Author::all() as $author)
                <option value="{{$author->id}}" {{old('author_id') == $author->id ? 'selected' : ''}}>
                    {{$author->name}}
                </option>
            @endforeach
        </select>
        @error('author_id')
            <span style="color: red">{{ $message }}</span>
        @enderror
    </div>
    
    <button type="submit">Add Book</button>
    <a href="{{route('books.index')}}">Cancel</a>
</form>

@if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li style="color:red">{{ $error }}</li>
        @endforeach
    </ul>
@endif