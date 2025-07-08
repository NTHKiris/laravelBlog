<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Post;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $posts = Post::with(['user', 'category'])->get();
            return PostResource::collection($posts);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            
            Gate::authorize('create', Post::class);
            $data = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'category_name' => 'required|string|max:255',
                'status' => 'required|in:published,privated'
            ]);

            $category = Category::firstOrCreate([
                'name' => $data['category_name']
            ]);
            $post = Post::create([
                'title' => $data['title'],
                'content' => $data['content'],
                'status' => $data['status'],
                'category_id' => $category->id,
                'user_id' => auth()->id()
            ]);

            $post->load('category', 'user');

            return new PostResource($post);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        Gate::authorize('view', $post);
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Post $post)
    {
        try {
            Gate::authorize('update', $post);

            $data = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'content' => 'sometimes|required|string',
                'category_name' => 'sometimes|required|string|max:255',
                'status' => 'sometimes|required|in:published,privated'
            ]);


            if (isset($data['category_name'])) {
                $category = Category::firstOrCreate([
                    'name' => $data['category_name']
                ]);
                $post->category_id = $category->id;
            }


            $updateData = collect($data)
                ->only(['title', 'content', 'status'])
                ->toArray();

            $post->fill($updateData);
            $post->save();

            $post->load('category', 'user');
            return new PostResource($post);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        try {
            Gate::authorize('delete', $post);

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
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
