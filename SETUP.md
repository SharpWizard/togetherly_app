# Togetherly Setup Guide - Windows

A complete step-by-step guide to set up Togetherly on Windows.

## Prerequisites Installation

### 1. Install PHP 8.1+

1. Download from: https://windows.php.net/downloads/releases/
2. Extract to a folder (e.g., `C:\php`)
3. Add to Windows PATH:
   - Right-click "This PC" → Properties
   - Advanced system settings → Environment Variables
   - Add `C:\php` to System PATH

Verify:
```bash
php --version
```

### 2. Install Composer

1. Download from: https://getcomposer.org/download/
2. Run the installer
3. Follow the installation wizard (choose your PHP path)

Verify:
```bash
composer --version
```

### 3. Install MySQL

1. Download from: https://dev.mysql.com/downloads/mysql/
2. Run installer and follow the wizard
3. Default port: 3306
4. Create root password

Verify:
```bash
mysql --version
```

### 4. Install Node.js

1. Download from: https://nodejs.org/ (LTS version)
2. Run installer and follow wizard

Verify:
```bash
node --version
npm --version
```

### 5. Install Git (Optional, for GitHub)

1. Download from: https://git-scm.com/download/win
2. Run installer with default settings

Verify:
```bash
git --version
```

---

## Project Setup

### Step 1: Navigate to Project Folder

```bash
cd C:\Users\Tanvir\togetherly_app
```

### Step 2: Install PHP Dependencies

```bash
composer install
```

This creates a `vendor` folder and installs all Laravel dependencies.

### Step 3: Install Node Dependencies

```bash
npm install
```

This creates `node_modules` and installs frontend dependencies.

### Step 4: Create .env File

```bash
copy .env.example .env
```

### Step 5: Generate Application Key

```bash
php artisan key:generate
```

You should see: `Application key set successfully.`

### Step 6: Create MySQL Database

**Option A: Using MySQL Command Line**

```bash
mysql -u root -p
```

Enter your MySQL password, then:

```sql
CREATE DATABASE togetherly;
EXIT;
```

**Option B: Using phpMyAdmin (if installed)**

1. Open http://localhost/phpmyadmin
2. Click "New" → Create database named "togetherly"

### Step 7: Configure Database in .env

Edit `C:\Users\Tanvir\togetherly_app\.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=togetherly
DB_USERNAME=root
DB_PASSWORD=your_mysql_password
```

### Step 8: Run Database Migrations

```bash
php artisan migrate
```

You should see tables being created successfully.

### Step 9: Compile Frontend Assets

```bash
npm run dev
```

For production:
```bash
npm run build
```

### Step 10: Create Storage Link

```bash
php artisan storage:link
```

This allows file uploads to work.

---

## Running the Application

### Terminal 1: Start Laravel Server

```bash
cd C:\Users\Tanvir\togetherly_app
php artisan serve
```

You'll see: `Server running on [http://127.0.0.1:8000]`

### Terminal 2: Watch for Asset Changes (Optional)

```bash
cd C:\Users\Tanvir\togetherly_app
npm run dev
```

### Open in Browser

Navigate to: **http://localhost:8000**

---

## First Time Usage

1. **Register**: Click "Get Started" and create an account
2. **Set Neighborhood**: Enter your neighborhood/district
3. **Share Food**: Click "Share Food" and post your first food item
4. **Share Skill**: Click "Share Skill" and offer a skill
5. **Browse**: See what's available in your neighborhood
6. **Message**: Click on a post and message the user
7. **Rate**: After exchanging, leave a rating

---

## Common Issues & Solutions

### Issue: "PHP is not recognized"

**Solution**: 
1. Restart Command Prompt (close and reopen)
2. Verify PHP is in PATH: `echo %PATH%`
3. Check PHP installation path is in the list

### Issue: "Composer not found"

**Solution**:
1. Reinstall Composer
2. Make sure to select "Install for all users"

### Issue: "MySQL connection refused"

**Solution**:
1. Check MySQL service is running:
   - Windows + R → `services.msc`
   - Find "MySQL80" and click "Start"
2. Verify password in .env matches your MySQL root password

### Issue: "SQLSTATE[HY000]: General error: 1030"

**Solution**:
```bash
php artisan migrate:refresh
```

### Issue: "npm not found"

**Solution**:
1. Reinstall Node.js
2. Restart Command Prompt
3. Verify: `npm --version`

### Issue: Uploads not working

**Solution**:
```bash
php artisan storage:link
```

And ensure `storage/app/public` directory exists.

---

## Troubleshooting Commands

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Fresh migrations (WARNING: deletes data)
php artisan migrate:fresh

# Create admin user (if seeder exists)
php artisan db:seed

# Check server status
php artisan tinker
```

---

## Next: Deploy to GitHub

See `GITHUB_SETUP.md` for instructions on uploading to GitHub.

---

## Support

For issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check MySQL error log
3. Run migrations again: `php artisan migrate`

Good luck! 🚀
