<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\FoodPost;
use App\Models\SkillPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Fills the community with realistic South Korea–based members, food posts
 * and skill posts (all with images) so the site looks lively. Idempotent:
 * safe to run multiple times (firstOrCreate on email / title+user).
 *
 * Also purges any legacy image-less posts so the feed shows only
 * rich, image-backed listings.
 */
class KoreaSeeder extends Seeder
{
    public function run(): void
    {
        // [name, email, neighborhood, account_type, rating, total, lat, lng]
        $people = [
            ['Min-jun Park',          'minjun.k@togetherly.app',   'Gangnam-gu',  'individual', 4.9, 23, 37.4979, 127.0276],
            ['Seo-yeon Kim',          'seoyeon.k@togetherly.app',  'Mapo-gu',     'individual', 4.8, 17, 37.5663, 126.9019],
            ['Ji-ho Lee',             'jiho.k@togetherly.app',     'Haeundae-gu', 'individual', 5.0, 31, 35.1631, 129.1639],
            ['Green Garden Cafe',     'greengarden@togetherly.app','Jongno-gu',   'restaurant', 4.7, 58, 37.5729, 126.9794],
            ['Ha-eun Jung',          'haeun@togetherly.app',       'Songpa-gu',   'individual', 4.9, 12, 37.5145, 127.1059],
            ['Do-yoon Choi',         'doyoon@togetherly.app',      'Seocho-gu',   'individual', 4.6,  9, 37.4837, 127.0324],
            ['Sora Artisan Bakery',  'sorabakery@togetherly.app',  'Mapo-gu',     'business',   4.8, 41, 37.5563, 126.9236],
            ['Ji-woo Kang',          'jiwoo@togetherly.app',       'Suyeong-gu',  'individual', 4.7, 15, 35.1456, 129.1130],
            ['Min-seo Yoon',         'minseo@togetherly.app',      'Nam-gu',      'individual', 5.0, 27, 35.1366, 129.0843],
            ['Hyun-woo Lim',         'hyunwoo@togetherly.app',     'Itaewon',     'individual', 4.5,  7, 37.5345, 126.9947],
            ['Eun-ji Han',           'eunji@togetherly.app',       'Yeonje-gu',   'individual', 4.9, 19, 35.1763, 129.0796],
            ['Seoul Sharing Kitchen','sharingkitchen@togetherly.app','Gangnam-gu','restaurant', 4.8, 64, 37.5045, 127.0490],
        ];

        $users = [];
        foreach ($people as $p) {
            $u = User::firstOrCreate(
                ['email' => $p[1]],
                ['name' => $p[0], 'phone' => '010-'.rand(1000,9999).'-'.rand(1000,9999),
                 'password' => Hash::make('password'), 'rating' => $p[4], 'total_ratings' => $p[5],
                 'bio' => 'Proud member of the '.$p[2].' community.']
            );
            UserProfile::firstOrCreate(
                ['user_id' => $u->id],
                ['neighborhood' => $p[2], 'is_verified' => true, 'account_type' => $p[3],
                 'latitude' => $p[6], 'longitude' => $p[7]]
            );
            $users[] = ['model' => $u, 'hood' => $p[2], 'lat' => $p[6], 'lng' => $p[7]];
        }

        // [title, description, food_type, quantity, image]
        $foods = [
            ['Homemade Kimchi (3 jars)', 'Fresh batch — made way too much for our family. Crisp and not too spicy!', 'cooked', 3, 'kimchi'],
            ['Sourdough & Baguettes', 'End-of-day surplus from the bakery. Still warm and crusty.', 'bakery', 8, 'bread'],
            ['Organic Balcony Veggies', 'Tomatoes, lettuce and herbs from my rooftop garden. Pesticide-free.', 'raw', 6, 'vegetables'],
            ['Bibimbap Meal Kits', 'Pre-portioned veg, rice and gochujang. Just mix and eat!', 'cooked', 4, 'bibimbap'],
            ['Korean BBQ Leftovers', 'Marinated bulgogi from a family gathering. Plenty to share.', 'cooked', 5, 'bbq'],
            ['Seasonal Fruit Basket', 'Korean pears and tangerines — bought too many at the market.', 'raw', 10, 'fruit'],
            ['Homemade Doenjang Soup', 'Hearty soybean-paste stew. Bring a container, it is generous!', 'cooked', 6, 'soup'],
            ['Freshly Steamed Rice', 'Cooked a big pot for an event. 4 portions still untouched.', 'cooked', 4, 'rice'],
            ['Japchae Glass Noodles', 'Sweet potato noodles with veggies. Vegetarian-friendly.', 'cooked', 5, 'noodles'],
            ['Tteokbokki Portions', 'Spicy rice cakes, made fresh this afternoon. 3 servings left.', 'cooked', 3, 'tteokbokki'],
            ['Castella Cake Slices', 'Soft honey sponge cake from the cafe. Best eaten today!', 'desserts', 12, 'dessert'],
            ['Cold Brew Coffee Bottles', 'Small-batch cold brew, over-roasted for the shop. Free to a good home.', 'drinks', 8, 'coffee'],
            ['Eomuk Fish Cakes', 'Busan-style fish cakes — great in soup or as a snack.', 'cooked', 7, 'fishcake'],
            ['Handmade Mandu Dumplings', 'Pork & kimchi dumplings, frozen and ready to steam.', 'cooked', 20, 'dumpling'],
            ['Garden Salad Boxes', 'Crisp mixed greens with a side of dressing. Made fresh.', 'raw', 5, 'salad'],
            ['Farm-Fresh Eggs', 'A neighbour gave us two trays — sharing one tray of 15.', 'raw', 15, 'eggs'],
            ['Wood-Fired Pizza Slices', 'Leftover from a pizza night — margherita & pepperoni. Still hot.', 'cooked', 8, 'pizza'],
            ['Club Sandwiches', 'Catering surplus from an office lunch. Wrapped and fresh.', 'cooked', 6, 'sandwich'],
            ['Korean Fried Chicken', 'Made a double batch of yangnyeom chicken — crispy and saucy!', 'cooked', 10, 'friedchicken'],
            ['Kimchi Jjigae (Stew)', 'A big warming pot of kimchi stew. Bring a container along.', 'cooked', 5, 'stew'],
            ['Warm Rice Porridge', 'Gentle juk, perfect if someone is feeling under the weather.', 'cooked', 4, 'porridge'],
            ['Savory Pajeon Pancakes', 'Green-onion & seafood pancakes, freshly pan-fried.', 'cooked', 6, 'pancake'],
            ['Fresh Seafood Platter', 'Extra from the fish market — shrimp, squid and clams on ice.', 'raw', 4, 'seafood'],
            ['Soft Tofu Sundubu', 'Silky soft-tofu stew base, mild and comforting.', 'cooked', 5, 'tofu'],
            ['Assorted Banchan Sides', 'Six little side dishes — namul, pickles and more.', 'cooked', 8, 'banchan'],
            ['Homemade Kimbap Rolls', 'Veggie & egg kimbap, sliced and ready. Great for a picnic.', 'cooked', 12, 'kimbap'],
            ['Fresh Fruit Smoothies', 'Made too many strawberry-banana smoothies. Chilled and ready.', 'drinks', 6, 'smoothie'],
            ['Greek Yogurt Cups', 'Plain & honey yogurt cups, a few days before best-by.', 'desserts', 9, 'yogurt'],
            ['Local Wildflower Honey', 'A jar of raw honey from a friend\'s rooftop hives.', 'other', 5, 'honey'],
            ['Homemade Strawberry Jam', 'Small-batch jam from this season\'s strawberries.', 'other', 7, 'jam'],
        ];
        foreach ($foods as $i => $f) {
            $owner = $users[$i % count($users)];
            FoodPost::firstOrCreate(
                ['title' => $f[0], 'user_id' => $owner['model']->id],
                ['description' => $f[1], 'food_type' => $f[2], 'quantity' => $f[3],
                 'image' => 'food/'.$f[4].'.jpg', 'status' => 'available',
                 'neighborhood' => $owner['hood'], 'latitude' => $owner['lat'], 'longitude' => $owner['lng'],
                 'expires_at' => now()->addDays(2 + ($i % 7)), 'views' => rand(5, 140)]
            );
        }

        // [title, description, category, level, available_times, image]
        $skills = [
            ['Guitar Lessons for Beginners', 'Learn your first songs on acoustic guitar. Patient, fun teaching.', 'music', 'beginner', 'Weekends 2-5 PM', 'guitar'],
            ['Home Cooking Basics', 'Cook 5 simple Korean dishes from scratch — banchan to bibimbap.', 'cooking', 'beginner', 'Flexible weekday evenings', 'cooking'],
            ['Intro to Web Coding', 'HTML, CSS and beginner JavaScript. Build your first web page.', 'coding', 'beginner', 'Mon & Wed 7 PM', 'coding'],
            ['Korean for Foreigners', 'Survival Korean for newcomers — greetings, ordering, directions.', 'languages', 'beginner', 'Tue & Thu evenings', 'korean'],
            ['English Conversation Practice', 'Relaxed English chat over coffee. All levels welcome.', 'languages', 'intermediate', 'Saturday mornings', 'english'],
            ['Morning Yoga Sessions', 'Gentle Hatha yoga in the park. Mats provided. Start your day right.', 'fitness', 'beginner', 'Daily 7-8 AM', 'yoga'],
            ['Watercolor Painting Class', 'Loosen up with watercolor landscapes. Materials included.', 'art', 'beginner', 'Sundays 3 PM', 'painting'],
            ['Photography Walks', 'Learn composition and lighting on a guided neighbourhood walk.', 'art', 'intermediate', 'Alternate weekends', 'photography'],
            ['Taekwondo Basics', 'Forms, kicks and discipline for all ages. Certified instructor.', 'fitness', 'beginner', 'Mon/Wed/Fri 6 PM', 'taekwondo'],
            ['Korean Calligraphy', 'Brush and ink basics — write your name in beautiful Hangul.', 'art', 'beginner', 'Thursday afternoons', 'calligraphy'],
            ['K-pop Dance Class', 'Learn the latest choreography. No experience needed, just energy!', 'other', 'beginner', 'Fri & Sat 5 PM', 'dance'],
            ['Piano for Kids & Adults', 'Read music and play your favourite tunes. Beginner to intermediate.', 'music', 'intermediate', 'Flexible', 'piano'],
            ['Knitting & Crochet Circle', 'Cozy weekly meetup. Bring yarn, leave with new skills and friends.', 'other', 'beginner', 'Wednesday 2 PM', 'knitting'],
            ['Urban Gardening Tips', 'Grow herbs and veg on a balcony. Composting and container tips.', 'other', 'beginner', 'Weekends', 'gardening'],
            ['Pottery & Ceramics Workshop', 'Hand-build a bowl or mug on the wheel. Clay and firing included.', 'art', 'beginner', 'Sundays 1 PM', 'pottery'],
            ['Sewing & Alterations', 'Hem trousers, fix zips, make a tote bag. Bring your machine or use mine.', 'other', 'beginner', 'Tuesdays 4 PM', 'sewing'],
            ['Chess Club for All Levels', 'Friendly games and tactics coaching. Boards provided.', 'other', 'intermediate', 'Friday evenings', 'chess'],
            ['Learn to Swim', 'Water confidence and basic strokes for nervous beginners.', 'fitness', 'beginner', 'Weekend mornings', 'swimming'],
            ['Makeup & Self-Care Basics', 'Everyday looks and skincare routines. Hands-on practice.', 'art', 'beginner', 'Flexible', 'makeup'],
            ['Drum Lessons', 'Find your rhythm on the kit — rudiments to first beats.', 'music', 'beginner', 'Wednesday 6 PM', 'drums'],
            ['Violin for Beginners', 'Posture, bowing and your first melodies. Loaner violins available.', 'music', 'beginner', 'Saturday 10 AM', 'violin'],
            ['Baking & Pastry Class', 'Master cookies, scones and a simple tart. Take your bakes home.', 'cooking', 'intermediate', 'Sundays 2 PM', 'baking'],
            ['Archery Introduction', 'Safety, stance and your first arrows at the range.', 'fitness', 'beginner', 'Weekends', 'archery'],
            ['Guided Meditation', 'Wind down with breathwork and mindfulness. All welcome.', 'fitness', 'beginner', 'Daily 8 PM', 'meditation'],
            ['Latte Art Barista Basics', 'Espresso, steaming milk and pouring your first heart.', 'cooking', 'beginner', 'Mon/Thu 3 PM', 'latteart'],
            ['Neighborhood Hiking Group', 'Easy weekend trails around the city. Fresh air and good company.', 'fitness', 'beginner', 'Saturday 7 AM', 'hiking'],
        ];
        foreach ($skills as $i => $s) {
            $owner = $users[($i + 3) % count($users)];
            SkillPost::firstOrCreate(
                ['title' => $s[0], 'user_id' => $owner['model']->id],
                ['description' => $s[1], 'category' => $s[2], 'skill_level' => $s[3],
                 'available_times' => $s[4], 'image' => 'skills/'.$s[5].'.jpg', 'status' => 'active',
                 'neighborhood' => $owner['hood'], 'latitude' => $owner['lat'], 'longitude' => $owner['lng'],
                 'views' => rand(8, 200)]
            );
        }

        // Purge legacy / image-less posts so the feed shows only image-backed
        // listings. SoftDeletes + cascade FKs make this safe.
        $deletedFood = FoodPost::where(fn ($q) => $q->whereNull('image')->orWhere('image', ''))->forceDelete();
        $deletedSkill = SkillPost::where(fn ($q) => $q->whereNull('image')->orWhere('image', ''))->forceDelete();

        $this->command->info('Korea seed complete: '.count($users).' members, '.count($foods).' food, '.count($skills).' skill posts. Purged '.$deletedFood.' food / '.$deletedSkill.' skill image-less posts.');
    }
}
