<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;
use App\Models\AnnouncementComment;
use App\Models\User;

class AnnouncementCommentSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::inRandomOrder()->take(5)->pluck('id');
        $announcements = Announcement::inRandomOrder()->take(5)->get();

        foreach ($announcements as $announcement) {
            foreach ($users as $userId) {
                AnnouncementComment::create([
                    'announcement_id' => $announcement->id,
                    'user_id'         => $userId,
                    'message'         => fake()->sentence(rand(6, 15)),
                    'created_at'      => now()->subMinutes(rand(5, 1000)),
                ]);
            }
        }
    }
}

