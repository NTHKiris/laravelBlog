<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at ? $this->email_verified_at : "Not Verify",
            'role' => $this->role->slug,
            'posts_count' => $this->posts ? $this->posts->count() : 0,
            'comments_count' => $this->comments ? $this->comments->count() : 0
        ];
    }
}
