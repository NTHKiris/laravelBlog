<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Http\Requests\UserRequest;
use App\Models\Country;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{


    public function index()
    {
        // $user = Auth::user();
        Gate::authorize('manage-users');
        $users = User::all();

        // $users = User::with('profile')->get();
        // $users = User::with('posts')->get();

        // $users = User::with([
        //     'posts:id,title,content,user_id',
        //     'profile:id,user_id,phone,address'
        // ])
        //     ->select('id', 'name', 'email')
        //     ->get();

        // $users = User::with('posts.category')->get();

        // $users = User::with(['posts.user', 'posts.comments'])->get(); // Lấy users với posts, user và comments của mỗi post

        // $users = User::with('groups')->get();

        // $users = User::with(
        //     'posts.category',
        //     'posts.comments.user.profile',
        //     'groups.users.country'
        // )->get();

        // $users = User::with([
        //     'groups' => function ($query) {
        //         $query->wherePivot('is_admin', true)
        //             ->where('groups.is_active', 1);
        //     }
        // ])->get();

        // $users = User::with('latestImage')->get();


        return view('users.index', compact('users'));
    }

    public function create()
    {
        Gate::authorize('manage-users');
        $countries = Country::all();
        return view('users.create', compact('countries'));
    }
    public function store(UserRequest $request)
    {
        Gate::authorize('manage-users');
        $data = $request->validated();
        User::create($data);
        return to_route('users.index');
    }
    public function showID($id)
    {
        Gate::authorize('manage-users');
        return $id;
    }
    public function Show($name)
    {
        Gate::authorize('manage-users');
        return "User: $name";
    }

    public function edit(string $id)
    {
        Gate::authorize('manage-users');
        $user = User::findOrFail($id);
        $countries = Country::all();
        return view('users.edit', compact('user', 'countries'));
    }

    public function update(UserRequest $request, string $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validated();
        $user->update($data);
        return to_route('users.index');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return to_route('users.index');
    }
    public function profile(string $id)
    {
        $user = User::find($id);
        return view('users.profile', compact('user'));
    }
    public function groups(string $id)
    {
        $user = User::find($id);
        return view('users.group', compact('user'));
    }


}
