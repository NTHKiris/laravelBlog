<h2>Edit book</h2>
<form action="{{route('books.update',$book->id)}}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Name:</label>
        <input type="text" name="name" value="{{old('name',$book->name)}}">
        @error('name')
            <span style="color: red">{{$message}}</span>
        @enderror
    </div>

    <div>
        <label>Type:</label>
        <select name="type">
            <option value="">Select type</option>
            <option value="novel" {{old('type', $book->type) == 'novel' ? 'selected' : ''}}>Novel</option>
            <option value="manga" {{old('type', $book->type) == 'manga' ?'selected' : ''}}>Manga</option>
            <option value="science" {{old('type', $book->type) == 'science' ?'selected' : ''}}>Science</option>
            <option value="news" {{old('type', $book->type) == 'news' ?'selected' : ''}}>News</option>
            <option value="document" {{old('type', $book->type) == 'document' ?'selected' : ''}}>Document</option>
        </select>
        @error('type')
            <span style="color: red">{{$message}}</span>
        @enderror
    </div>

    <div>
        <label>Price:</label>
        <input type="number" name="price" placeholder="Enter price" value="{{old('price',$book->price)}}" >
       @error('price')
            <span style="color: red">{{$message}}</span>
        @enderror
    </div>
    
    <div>
        <label>Description:</label>
        <textarea name="description" placeholder="Enter description" rows="4">{{old('description',$book->description)}}</textarea>
       @error('description')
            <span style="color: red">{{$message}}</span>
        @enderror
    </div>
    <div>
        <label>Author:</label>
        <select name="author_id">
            <option value="">Select author</option>
            @foreach(\App\Models\Author::all() as $author)
                <option value="{{$author->id}}" {{old('author_id',$book->author_id) == $author->id ? 'selected' : ''}}>
                    {{$author->name}}
                </option>
            @endforeach
        </select>
        @error('author_id')
            <span style="color: red">{{$message}}</span>
        @enderror
    </div>
    <button type="submit">Save</button>
    <a href="{{route('books.index')}}">Cancel</a>
</form>