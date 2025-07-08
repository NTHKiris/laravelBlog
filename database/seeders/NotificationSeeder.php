<?php
// database/seeders/NotificationSeeder.php

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Tạo dữ liệu mới
        $notifications = Notification::factory(20)->create();
        $users = User::all();
        $teachers = Teacher::all();


        foreach ($notifications as $notification) {
            // Gắn notification cho users
            $randomUsers = $users->random(rand(2, min(5, $users->count())));
            foreach ($randomUsers as $user) {
                $notification->users()->attach($user->id, [
                    'read_at' => fake()->boolean(30) ? now()->subDays(rand(1, 7)) : null
                ]);
            }

            // Gắn notification cho teachers
            if ($teachers->count() > 0) {
                $randomTeachers = $teachers->random(rand(1, min(3, $teachers->count())));
                foreach ($randomTeachers as $teacher) {
                    $notification->teachers()->attach($teacher->id, [
                        'read_at' => fake()->boolean(40) ? now()->subDays(rand(1, 5)) : null
                    ]);
                }
            }
        }


    }
}