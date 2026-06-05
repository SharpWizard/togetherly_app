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

        // Food posts
        $foods = [
            ['Homemade Kimchi', 'Fresh batch, made too much for our family. 3 jars to share!', 'cooked', 3],
            ['Fresh Bakery Bread', 'End-of-day surplus from our cafe — sourdough & baguettes.', 'bakery', 8],
            ['Organic Vegetables', 'Extra veggies from my balcony garden — tomatoes, lettuce, herbs.', 'raw', 5],
            ['Leftover Catering Food', 'Office event leftovers — sandwiches & fruit platters. Still fresh!', 'leftovers', 12],
        ];
        foreach ($foods as $i => $f) {
            FoodPost::firstOrCreate(
                ['title' => $f[0], 'user_id' => $users[$i % count($users)]->id],
                ['description' => $f[1], 'food_type' => $f[2], 'quantity' => $f[3],
                 'status' => 'available', 'neighborhood' => $hood, 'latitude' => 35.16, 'longitude' => 129.16,
                 'expires_at' => now()->addDays(2 + $i)]
            );
        }

        // Skill posts
        $skills = [
            ['Guitar Lessons for Beginners', 'Learn your first songs! Acoustic guitar, patient teaching.', 'music', 'intermediate', 'Weekends 2-5 PM'],
            ['Korean ↔ English Exchange', 'Native Korean speaker, fluent English. Let\'s practice together!', 'languages', 'beginner', 'Tue & Thu evenings'],
            ['Home Cooking Basics', 'Learn to cook 5 simple Korean dishes from scratch.', 'cooking', 'beginner', 'Flexible'],
            ['Intro to Web Coding', 'HTML, CSS & basic JavaScript for total beginners.', 'coding', 'advanced', 'Mon/Wed 7 PM'],
        ];
        foreach ($skills as $i => $s) {
            SkillPost::firstOrCreate(
                ['title' => $s[0], 'user_id' => $users[$i % count($users)]->id],
                ['description' => $s[1], 'category' => $s[2], 'skill_level' => $s[3],
                 'available_times' => $s[4], 'status' => 'active',
                 'neighborhood' => $hood, 'latitude' => 35.16, 'longitude' => 129.16]
            );
        }

        // A welcome message to the demo user
        Message::firstOrCreate(
            ['sender_id' => $users[0]->id, 'recipient_id' => $demo->id, 'message' => 'Hi! Welcome to Togetherly 👋 Is the kimchi still available?'],
            ['is_read' => false]
        );

        $this->command->info('Demo data seeded! Login: demo@togetherly.app / password');
    }
}
