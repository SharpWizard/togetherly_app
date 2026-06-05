# Togetherly - Quick Start (5 Minutes)

## What You Need

1. PHP 8.1+
2. Composer
3. MySQL
4. Node.js
5. Git (for GitHub)

[Detailed Setup → See SETUP.md](SETUP.md)

## Quick Commands

### Step 1: Project Setup

```bash
cd C:\Users\Tanvir\togetherly_app
composer install
npm install
```

### Step 2: Configure Database

1. Create MySQL database:
```bash
mysql -u root -p
CREATE DATABASE togetherly;
EXIT;
```

2. Edit `.env` file:
```
DB_DATABASE=togetherly
DB_USERNAME=root
DB_PASSWORD=your_password
```

### Step 3: Initialize App

```bash
php artisan key:generate
php artisan migrate
npm run dev
php artisan storage:link
```

### Step 4: Run Server

**Terminal 1:**
```bash
php artisan serve
```

**Terminal 2 (optional):**
```bash
npm run dev
```

### Step 5: Open in Browser

Visit: **http://localhost:8000**

---

## Done! 🎉

Register a test account and start:
- ✅ Share food
- ✅ Share skills
- ✅ Message users
- ✅ Rate community members

---

## Deploy to GitHub

```bash
git init
git remote add origin https://github.com/YOUR_USERNAME/togetherly_app.git
git add .
git commit -m "Initial commit"
git branch -M main
git push -u origin main
```

[Detailed GitHub Guide → See GITHUB_SETUP.md](GITHUB_SETUP.md)

---

## Key Features Implemented

| Feature | Status |
|---------|--------|
| User Authentication | ✅ Complete |
| Food Sharing (CRUD) | ✅ Complete |
| Skill Sharing (CRUD) | ✅ Complete |
| Location-based Feed | ✅ Complete |
| In-App Messaging | ✅ Complete |
| Community Ratings | ✅ Complete |
| User Profiles | ✅ Complete |
| Dashboard | ✅ Complete |

---

## Project Structure

```
togetherly_app/
├── app/Http/Controllers/        # Main logic
├── app/Models/                  # Database models
├── database/migrations/          # Database schema
├── resources/views/              # HTML templates
├── routes/web.php               # URL routes
├── .env.example                 # Config template
├── SETUP.md                     # Installation guide
├── GITHUB_SETUP.md              # GitHub guide
└── README.md                    # Full documentation
```

---

## Common Tasks

### Add a New Route
Edit `routes/web.php`:
```php
Route::get('/new-page', [NewController::class, 'index'])->name('new.index');
```

### Create New Migration
```bash
php artisan make:migration create_table_name_table
```

### Create New Model
```bash
php artisan make:model ModelName -m
```

### Create New Controller
```bash
php artisan make:controller ControllerName
```

### View Database
```bash
# Via MySQL command line
mysql -u root -p togetherly

# Or use phpMyAdmin
http://localhost/phpmyadmin
```

---

## Troubleshooting

| Issue | Solution |
|-------|----------|
| "PHP not found" | Restart terminal, check PATH |
| "Composer not found" | Reinstall Composer, restart |
| "MySQL connection refused" | Start MySQL service, check password |
| "Port 8000 in use" | `php artisan serve --port=8001` |
| "Database connection error" | Check `.env` settings |

[Full Troubleshooting → See SETUP.md](SETUP.md)

---

## Next Steps

1. **Customize**: Add your logo, colors, features
2. **Test**: Try all features thoroughly
3. **Deploy**: Host on Heroku, Railway, or your server
4. **Share**: Get feedback from users

---

## Important Files

- `.env` - Your configuration (keep secret!)
- `storage/logs/laravel.log` - Error logs
- `database/migrations/` - Your database structure
- `resources/views/` - Your HTML pages

---

## Get Help

- 📚 [Laravel Docs](https://laravel.com/docs)
- 🔧 [Stack Overflow](https://stackoverflow.com/questions/tagged/laravel)
- 💬 GitHub Issues on your repo

---

**Ready to build community? Let's go!** 🚀

Need detailed setup? → [SETUP.md](SETUP.md)
Need GitHub help? → [GITHUB_SETUP.md](GITHUB_SETUP.md)
Need full docs? → [README.md](README.md)
