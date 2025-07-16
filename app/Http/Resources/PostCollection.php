<?php


namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'content' => \Str::limit(strip_tags($post->content), 150),
                    'created_at' => $post->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $post->updated_at->format('Y-m-d H:i:s'),
                    'category' => $post->category->name,
                    'status' => $post->status,
                    'author' => $post->user->name,
                    'thumpnail' => $post->thumpnail ? $post->thumpnail->path : null,
                    'comments_count' => $post->comments()->count(),
                ];
            }),
            'meta' => [
                'total_count' => $this->collection->count(),

            ]

        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        return [
            'success' => true,
            'message' => 'Posts retrieved successfully',
            'status' => 200,
        ];
    }
}