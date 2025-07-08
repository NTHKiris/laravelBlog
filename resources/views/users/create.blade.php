<x-app-layout>

    <h2>Create User</h2>
    <form action="{{route('users.store')}}" method="POST">
        @csrf
        <label>Name</label>
        <input type="text" name="name" value="{{old('name')}}">
        @error('name')
            <span style="color: red">{{$message}}</span>
        @enderror
        <br>
        <label>Email</label>
        <input type="email" name="email" value="{{old('email')}}">
        @error('email')
            <span style="color: red">{{$message}}</span>
        @enderror
        <br>
        <label>Password</label>
        <input type="password" name="password" value="{{old('password')}}">
        @error('password')
            <span style="color: red">{{$message}}</span>
        @enderror
        <br>
        <label>Comfirm Password</label>
        <input type="password" name="password_confirmation" value="{{old('password')}}">
        @error('password')
            <span style="color: red">{{$message}}</span>
        @enderror
        <br>
        <label>Country</label>
        <select name="country_id">
            <option value="">Select country</option>
            @foreach ($countries as $country)
                <option value="{{$country->id}}" {{old('country_id') == $country->id ? 'selected' : ''}}>
                    {{$country->name}}
                </option>
            @endforeach
        </select>
        <br>
        @error('country')
            <span style="color: red">{{$message}}</span>
        @enderror
        <button type="submit" class="p-4 bg-green-500 rounded">Create</button>
    </form>
</x-app-layout>