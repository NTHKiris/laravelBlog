<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('view-posts');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Post $post): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        if ($user->id === $post->user_id) {
            return true;
        }
        if ($user->hasPermission('view-posts') && $post->status === 'published') {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('create-posts') || $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Post $post): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        if ($user->id == $post->user_id && $user->hasPermission('edit-posts')) {
            return true;
        }
        if ($user->hasRole('editor') && $user->hasPermission('edit-posts')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Post $post): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        if ($user->id === $post->user_id && $user->hasPermission('delete-posts')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Post $post): bool
    {
        return (bool) $user->isAdmin();
    }

    public function publish(User $user, Post $post)
    {
        // Chỉ admin hoặc editor mới có thể publish
        return $user->hasRole(['admin', 'editor']) && $user->hasPermission('publish-posts');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}
