<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Tạo permissions với kiểm tra tồn tại
        $permissions = [
            ['name' => 'Xem bài viết', 'slug' => 'view-posts'],
            ['name' => 'Tạo bài viết', 'slug' => 'create-posts'],
            ['name' => 'Sửa bài viết', 'slug' => 'edit-posts'],
            ['name' => 'Xóa bài viết', 'slug' => 'delete-posts'],
            ['name' => 'Xuất bản bài viết', 'slug' => 'publish-posts'],
            ['name' => 'Lưu trữ bài viết', 'slug' => 'archive-posts'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['slug' => $permission['slug']], // Tìm theo slug
                $permission // Tạo mới nếu không tồn tại
            );
        }


        $adminRole = Role::firstOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Quản trị viên hệ thống'
            ]
        );

        $editorRole = Role::firstOrCreate(
            ['slug' => 'editor'],
            [
                'name' => 'Editor',
                'slug' => 'editor',
                'description' => 'Biên tập viên'
            ]
        );

        $authorRole = Role::firstOrCreate(
            ['slug' => 'author'],
            [
                'name' => 'Author',
                'slug' => 'author',
                'description' => 'Tác giả'
            ]
        );

        $userRole = Role::firstOrCreate(
            ['slug' => 'user'],
            [
                'name' => 'User',
                'slug' => 'user',
                'description' => 'Người dùng thường'
            ]
        );
        $bannedRole = Role::firstOrCreate(
            ['slug' => 'banned'],
            [
                'name' => 'Banned',
                'slug' => 'banned',
                'description' => 'Người dùng bị cấm'
            ]
        );

        // Lấy permissions theo slug
        $viewPosts = Permission::where('slug', 'view-posts')->first();
        $createPosts = Permission::where('slug', 'create-posts')->first();
        $editPosts = Permission::where('slug', 'edit-posts')->first();
        $deletePosts = Permission::where('slug', 'delete-posts')->first();
        $publishPosts = Permission::where('slug', 'publish-posts')->first();


        // Gán quyền cho role (sync để tránh duplicate)
        $adminRole->permissions()->sync([
            $viewPosts->id,
            $createPosts->id,
            $editPosts->id,
            $deletePosts->id,
            $publishPosts->id,

        ]);

        $editorRole->permissions()->sync([
            $viewPosts->id,
            $createPosts->id,
            $editPosts->id,
            $deletePosts->id,
            $publishPosts->id,
        ]);

        $authorRole->permissions()->sync([
            $viewPosts->id,
            $createPosts->id,
            $editPosts->id,
            $deletePosts->id
        ]);

        $userRole->permissions()->sync([$viewPosts->id]);

        // Tạo users mẫu với kiểm tra tồn tại
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
            ]
        );
        $admin->roles()->sync([$adminRole->id]);

        $editor = User::firstOrCreate(
            ['email' => 'editor@gmail.com'],
            [
                'name' => 'Editor User',
                'email' => 'editor@gmail.com',
                'password' => Hash::make('password'),
            ]
        );
        $editor->roles()->sync([$editorRole->id]);

        $author = User::firstOrCreate(
            ['email' => 'author@gmail.com'],
            [
                'name' => 'Author User',
                'email' => 'author@gmail.com',
                'password' => Hash::make('password'),
            ]
        );
        $author->roles()->sync([$authorRole->id]);

        $user = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Normal User',
                'email' => 'user@gmail.com',
                'password' => Hash::make('password'),
            ]
        );
        $user->roles()->sync([$userRole->id]);
    }
}