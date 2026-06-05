# Togetherly - Share Food. Share Skills. Build Community.

A Laravel-based community platform where users can share surplus food and skills with their neighbors.

## Features

- **Food Sharing**: Post surplus food, browse available food from neighbors, claim items locally
- **Skill Sharing**: Teach and learn skills within your community
- **Location-Based Feed**: See only posts from your neighborhood
- **In-App Messaging**: Direct communication between users
- **Community Ratings**: Build trust through user ratings and reviews
- **User Profiles**: Maintain reputation with ratings and history

## Tech Stack

- **Backend**: Laravel 10
- **Database**: MySQL
- **Frontend**: Bootstrap 5
- **Language**: PHP 8.1+

## Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL 5.7 or higher
- Node.js (for asset compilation)

## Installation & Setup

### 1. Install Dependencies

```bash
cd togetherly_app
composer install
npm install
```

### 2. Create Environment File

```bash
cp .env.example .env
```

### 3. Generate Application Key

```bash
php artisan key:generate
```

### 4. Configure Database

Edit `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=togetherly
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Create Database

```bash
mysql -u root -p
CREATE DATABASE togetherly;
EXIT;
```

### 6. Run Migrations

```bash
php artisan migrate
```

### 7. Compile Frontend Assets

```bash
npm run dev
```

Or for production:
```bash
npm run build
```

### 8. Create Storage Link

```bash
php artisan storage:link
```

### 9. Start the Development Server

```bash
php artisan serve
```

The app will be available at: **http://localhost:8000**

## Project Structure

```
togetherly_app/
├── app/
│   ├── Http/Controllers/     # Route handlers
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── FoodPostController.php
│   │   ├── SkillPostController.php
│   │   ├── MessageController.php
│   │   └── RatingController.php
│   └── Models/               # Database models
│       ├── User.php
│       ├── FoodPost.php
│       ├── SkillPost.php
│       ├── Message.php
│       ├── Rating.php
│       └── UserProfile.php
├── database/
│   ├── migrations/           # Database schema
│   └── seeders/              # Sample data
├── resources/
│   └── views/                # Blade templates
│       ├── auth/
│       ├── food/
│       ├── skills/
│       ├── messages/
│       └── layouts/
├── routes/
│   └── web.php               # Route definitions
└── storage/                  # File uploads
```

## Core Models & Relationships

### User
- Has one UserProfile
- Has many FoodPosts
- Has many SkillPosts
- Has many sent/received Messages
- Has many given/received Ratings

### FoodPost
- Belongs to User
- Has many Messages
- Has many Ratings

### SkillPost
- Belongs to User
- Has many Messages
- Has many Ratings

### Message
- Belongs to sender User
- Belongs to recipient User
- Belongs to FoodPost (optional)
- Belongs to SkillPost (optional)

### Rating
- Belongs to rater User
- Belongs to rated User
- Belongs to FoodPost (optional)
- Belongs to SkillPost (optional)

## Database Schema

### Users
- id, name, email, phone, password, avatar, bio, rating, total_ratings, timestamps

### User Profiles
- id, user_id, neighborhood, address, latitude, longitude, radius_km, is_verified, timestamps

### Food Posts
- id, user_id, title, description, image, food_type, status, neighborhood, latitude, longitude, quantity, expires_at, timestamps, soft_delete

### Skill Posts
- id, user_id, title, description, category, skill_level, available_times, neighborhood, latitude, longitude, status, timestamps, soft_delete

### Messages
- id, sender_id, recipient_id, food_post_id, skill_post_id, message, is_read, read_at, timestamps

### Ratings
- id, rater_id, rated_user_id, food_post_id, skill_post_id, rating, comment, timestamps

## Routes Overview

### Authentication
- `GET /register` - Register page
- `POST /register` - Store registration
- `GET /login` - Login page
- `POST /login` - Store login
- `POST /logout` - Logout

### Dashboard
- `GET /dashboard` - Main dashboard with recent posts

### Food Posts
- `GET /food` - List all food posts
- `GET /food/create` - Create food post form
- `POST /food` - Store food post
- `GET /food/{id}` - View single food post
- `GET /food/{id}/edit` - Edit form
- `PUT /food/{id}` - Update food post
- `DELETE /food/{id}` - Delete food post

### Skill Posts
- `GET /skills` - List all skills
- `GET /skills/create` - Create skill form
- `POST /skills` - Store skill post
- `GET /skills/{id}` - View single skill
- `GET /skills/{id}/edit` - Edit form
- `PUT /skills/{id}` - Update skill
- `DELETE /skills/{id}` - Delete skill

### Messages
- `GET /messages/inbox` - View inbox
- `GET /messages/sent` - View sent messages
- `GET /messages/conversation/{userId}` - View conversation with user
- `POST /messages/send/{userId}` - Send message

### Ratings
- `POST /ratings` - Submit rating

## Usage Guide

### For Users

1. **Register**: Create account with name, email, phone, and neighborhood
2. **Share Food**: Post surplus food in under 30 seconds with photo and expiry time
3. **Share Skills**: List your skills and availability
4. **Browse**: See food/skills from your neighborhood
5. **Connect**: Message users to arrange pickup or lessons
6. **Rate**: Rate users after exchanging food or skills

### For Restaurants/Businesses

1. Register as a regular user
2. Post daily surplus food
3. Build reputation through ratings
4. Access premium features to gain visibility

## Next Steps (Future Features)

- [ ] Advanced location filtering and maps integration
- [ ] Push notifications for new posts
- [ ] Verified badges for restaurants/businesses
- [ ] Premium subscription tiers
- [ ] Analytics dashboard for business users
- [ ] Mobile app (React Native)
- [ ] Government grant integration
- [ ] CSR partnership program
- [ ] Multi-language support
- [ ] Expansion to other cities

## Contributing

Contributions are welcome! Please follow Laravel coding standards.

## License

This project is open source and available under the MIT license.

## Support

For issues and questions:
- Email: busan@togetherly.app
- Website: togetherly.app

---

**Vision**: A world where nothing goes to waste — not food, not knowledge, not kindness.
