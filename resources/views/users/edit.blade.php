<x-app-layout>

    <h2>Edit user</h2>

    <form action="{{route('users.update', $user->id)}}" method="POST">
        @csrf
        @method('PUT')
        <label>name</label>
        <input type="text" name="nameee" value="{{old('', $user->name)}}">
        @error('name')
            <span style="color: red">{{$message}}</span>
        @enderror
        <label>email</label>
        <input type="text" name="email" value="{{old('', $user->email)}}">
        @error('email')
            <span style="color: red">{{$message}}</span>
        @enderror
        <label>password</label>
        <input type="text" name="password">
        @error('password')
            <span style="color: red">{{$message}}</span>
        @enderror
        <label>confirm password</label>
        <input type="text" name="password_confirmation">
        @error('password_confirmation')
            <span style="color: red">{{$message}}</span>
        @enderror
        <label>country</label>

        <select name="country_id">
            <option value="">Select country</option>
            @foreach ($countries as $country)
                <option value="{{ $country->id }}" {{ old('country_id', $user->country_id) == $country->id ? 'selected' : '' }}>
                    {{ $country->name }}
                </option>
            @endforeach
        </select>
        @error('country')
            <span style="color: red">{{$message}}</span>
        @enderror
        <button type="submit">
            Update User
        </button>
        <a href="{{ route('users.index') }}">
            Cancel
        </a>
    </form>
</x-app-layout>