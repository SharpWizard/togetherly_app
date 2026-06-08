<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\FoodPost;
use App\Models\SkillPost;
use App\Models\Message;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $hood = 'Haeundae-gu';

        // Demo account
        $demo = User::firstOrCreate(
            ['email' => 'demo@togetherly.app'],
            ['name' => 'Demo User', 'phone' => '010-0000-0000', 'password' => Hash::make('password'),
             'bio' => 'Just exploring Togetherly!', 'rating' => 5.0, 'total_ratings' => 4]
        );
        UserProfile::firstOrCreate(['user_id' => $demo->id],
            ['neighborhood' => $hood, 'is_verified' => true]);

        // Admin account
        $admin = User::firstOrCreate(['email' => 'admin@togetherly.app'],
            ['name' => 'Admin', 'phone' => '010-9999-9999', 'password' => Hash::make('password'),
             'is_admin' => true, 'rating' => 5.0, 'total_ratings' => 0]);
        $admin->update(['is_admin' => true]);
        UserProfile::firstOrCreate(['user_id' => $admin->id],
            ['neighborhood' => $hood, 'is_verified' => true, 'account_type' => 'individual']);

        // Neighbors  [name, email, rating, total, account_type]
        $neighbors = [
            ['Min-jun Park', 'minjun@togetherly.app', 4.9, 23, 'individual'],
            ['Seo-yeon Kim', 'seoyeon@togetherly.app', 4.8, 17, 'individual'],
            ['Ji-ho Lee', 'jiho@togetherly.app', 5.0, 31, 'individual'],
            ['Green Garden Cafe', 'cafe@togetherly.app', 4.7, 58, 'restaurant'],
        ];
        $users = [];
        foreach ($neighbors as $n) {
            $u = User::firstOrCreate(['email' => $n[1]],
                ['name' => $n[0], 'phone' => '010-1111-2222', 'password' => Hash::make('password'),
                 'rating' => $n[2], 'total_ratings' => $n[3]]);
            UserProfile::firstOrCreate(['user_id' => $u->id],
                ['neighborhood' => $hood, 'is_verified' => true, 'account_type' => $n[4]]);
            $users[] = $u;
        }

        // NOTE: Demo food/skill posts were removed — all post content is now
        // seeded (with images) by KoreaSeeder, and image-less posts are purged.

        // A welcome message to the demo user
        Message::firstOrCreate(
            ['sender_id' => $users[0]->id, 'recipient_id' => $demo->id, 'message' => 'Hi! Welcome to Togetherly 👋 Is the kimchi still available?'],
            ['is_read' => false]
        );

        $this->command->info('Demo data seeded! Login: demo@togetherly.app / password');
    }
}
