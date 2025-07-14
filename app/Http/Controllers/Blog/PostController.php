<?php

namespace App\Http\Controllers\Blog;
use App\Http\Requests\Blog\PostRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;
use App\Models\Category;
use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $posts = Post::with(['user', 'category', 'comments', 'thumpnail'])->orderBy('created_at', 'desc')->get();
            return new PostCollection($posts);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], 500);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $this->authorize('create', Post::class);
        $category = Category::firstOrCreate([
            'name' => $request->category_name
        ]);
        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'category_id' => $category->id,
            'user_id' => Auth::id(),

        ]);

        // if ($request->has('thumpnail')) {
        //     $post->thumpnail()->create([
        //         'path' => $request->thumpnail,
        //         'type' => 'thumpnail'
        //     ]);
        // }


        $post->load(['user', 'category', 'thumpnail']);
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $this->authorize('view', $post);
        $post->load(['user', 'category', 'thumpnail', 'comments']);
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('update', $post);
        if ($request->has('category_name')) {
            $category = Category::firstOrCreate([
                'name' => $request->category_name
            ]);
            $post->category_id = $category->id;
        }

        $updateData = collect($request->validated())->only(['title', 'content', 'status'])->toArray();
        $post->fill($updateData);
        $post->save();
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $postId = $post->id;
        $postTitle = $post->title;

        $post->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Delete successfully',
            'data' => [
                'id' => $postId,
                'title' => $postTitle
            ]
        ], 200);
    }
    public function restore($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $this->authorize('restore', $post);
        if (!$post->trashed()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Post is not deleted'
            ], 400);
        }

        $post->restore();

        return response()->json([
            'status' => 'success',
            'message' => 'Restore successfully',
            'data' => [
                'id' => $post->id,
                'title' => $post->title
            ]
        ], 200);
    }

    public function forceDelete($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $post);
        if (!$post->trashed()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Post is not deleted'
            ], 400);
        }

        $post->forceDelete();

        return response()->json([
            'status' => 'success',
            'message' => 'Force delete successfully',
            'data' => [
                'id' => $post->id,
                'title' => $post->title
            ]
        ], 200);
    }
    public function comments($id)
    {
        $post = Post::findOrFail($id);
        $comments = $post->comments()->with(['user', 'post'])->orderBy('created_at', 'desc')->get();
        return CommentResource::collection($comments);
    }

}
