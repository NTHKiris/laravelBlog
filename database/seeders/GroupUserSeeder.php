<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Group;

class GroupUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $groups = Group::all();

        if ($users->count() === 0 || $groups->count() === 0) {
            $this->command->warn('No users or groups found. Skipping GroupUser seeding.');
            return;
        }

        foreach ($groups as $group) {
            $adminUsers = $users->random(rand(1, min(2, $users->count())));
            
            foreach ($adminUsers as $admin) {
                $group->users()->attach($admin->id, [
                    'joined_at' => now()->subDays(rand(30, 90)),
                    'is_admin' => true
                ]);
            }

            $availableUsers = $users->diff($adminUsers);
            $memberUsers = $availableUsers->random(rand(3, min(7, $availableUsers->count())));
            
            foreach ($memberUsers as $member) {
                if (!$group->users()->where('user_id', $member->id)->exists()) {
                    $group->users()->attach($member->id, [
                        'joined_at' => now()->subDays(rand(1, 60)),
                        'is_admin' => false
                    ]);
                }
            }
        }

        $this->command->info('GroupUser relationships seeded successfully!');
   
    }
}
