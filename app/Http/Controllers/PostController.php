<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Hiển thị danh sách bài viết
     */
    public function index()
    {
        Gate::authorize('viewAny', Post::class);

        $posts = Post::with('user')->get();
        return view('posts.index', compact('posts'));
    }

    /**
     * Hiển thị form tạo bài viết
     */
    public function create()
    {
        Gate::authorize('create', Post::class);

        return view('posts.create');
    }

    /**
     * Lưu bài viết mới
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Post::class);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:published,privated',
        ]);

        $post = Post::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'category_id' => $validated['category_id'],
            'status' => $validated['status'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Bài viết đã được tạo thành công!');
    }

    /**
     * Hiển thị bài viết
     */
    public function show(Post $post)
    {
        Gate::authorize('view', $post);

        return view('posts.show', compact('post'));
    }

    /**
     * Hiển thị form sửa bài viết
     */
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    /**
     * Cập nhật bài viết
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $post->update($validated);

        return redirect()->route('posts.show', $post)
            ->with('success', 'Bài viết đã được cập nhật!');
    }

    /**
     * Xóa bài viết
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Bài viết đã được xóa!');
    }

    /**
     * Publish bài viết
     */
    public function publish(Post $post)
    {
        Gate::authorize('publish', $post);

        $post->update(['status' => 'published']);

        return back()->with('success', 'Bài viết đã được xuất bản!');
    }


}