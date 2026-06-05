# 🚀 START HERE - Togetherly Setup

## You Have XAMPP Running ✓

Great! Apache and MySQL are already active. Now let's set up Togetherly automatically.

---

## ⚡ Quick Setup (Choose One)

### Option 1: PowerShell (Recommended for Windows)

1. **Open PowerShell as Administrator**
   - Press `Windows Key + X` → Select "Windows PowerShell (Admin)"

2. **Navigate to project folder**
   ```powershell
   cd C:\Users\Tanvir\togetherly_app
   ```

3. **Allow script execution** (one time only)
   ```powershell
   Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
   ```
   Type `Y` and press Enter

4. **Run the setup script**
   ```powershell
   .\setup.ps1
   ```

5. **Wait for completion** - It will:
   - Install PHP dependencies (composer)
   - Install frontend dependencies (npm)
   - Create .env file
   - Generate app key
   - Create database
   - Run migrations
   - Create storage link

---

### Option 2: Command Prompt Batch File

1. **Open Command Prompt**
   - Press `Windows Key + R` → Type `cmd` → Press Enter

2. **Navigate to project**
   ```cmd
   cd C:\Users\Tanvir\togetherly_app
   ```

3. **Run setup**
   ```cmd
   setup.bat
   ```

4. **Wait for completion**

---

## ✅ After Setup Completes

Once the script finishes, follow these steps:

### Terminal 1: Start Laravel Server

```bash
cd C:\Users\Tanvir\togetherly_app
php artisan serve
```

You'll see:
```
Server running on [http://127.0.0.1:8000]
```

### Terminal 2: Start Frontend Build (Optional but Recommended)

Open a NEW PowerShell/Command Prompt in the same folder:

```bash
npm run dev
```

---

## 🌐 Open in Browser

Go to: **http://localhost:8000**

You should see the Togetherly welcome page!

---

## ✨ Test the App

1. **Register** 
   - Click "Get Started"
   - Fill in: Name, Email, Phone, Neighborhood
   - Create password

2. **Share Food**
   - Click "Share Food"
   - Fill in: Title, Type, Quantity, Expiry
   - Add photo (optional)
   - Click "Share Food"

3. **Share Skill**
   - Click "Share Skill"
   - Fill in: Skill Name, Category, Level
   - Click "Share Skill"

4. **View Dashboard**
   - See your posts
   - See community posts

5. **Try Messaging**
   - Create another account
   - Try to message first user
   - Send a message

6. **Try Ratings**
   - Rate a user
   - Check if rating updates

---

## 🆘 Troubleshooting

### Problem: "PHP is not recognized"
**Solution:**
- Make sure XAMPP is properly installed
- Restart Command Prompt/PowerShell
- Or use full path: `C:\xampp\php\php.exe artisan serve`

### Problem: "MySQL connection refused"
**Solution:**
- Check XAMPP Control Panel
- Make sure MySQL is "Running" (green)
- Port 3306 should be active

### Problem: "Composer not found"
**Solution:**
- Restart Command Prompt/PowerShell
- Or reinstall Composer from https://getcomposer.org

### Problem: Port 8000 already in use
**Solution:**
```bash
php artisan serve --port=8001
```

### Problem: Database not created
**Solution:**
1. Go to: http://localhost/phpmyadmin
2. Click "New" → Create database: `togetherly`
3. Run: `php artisan migrate`

---

## 📋 What the Script Does

1. ✅ Installs PHP dependencies (composer install)
2. ✅ Installs Frontend dependencies (npm install)
3. ✅ Creates .env configuration file
4. ✅ Generates Laravel application key
5. ✅ Creates MySQL database
6. ✅ Runs database migrations
7. ✅ Creates storage link for uploads

**Total time:** ~5-10 minutes (depending on internet speed)

---

## 🎯 Expected Output

After script completes, you should see:
```
============================================
   Setup Complete!
============================================

Next Steps:
1. Make sure XAMPP services are running
   • Apache
   • MySQL

2. Open TWO Command Prompts:
   Terminal 1: php artisan serve
   Terminal 2: npm run dev

3. Open your browser:
   http://localhost:8000

4. Register and test the app!
```

---

## 🚀 You're Ready!

If setup succeeded, your app is ready to run. Open http://localhost:8000 and enjoy! 

**Need help?** Check QUICK_START.md or SETUP.md

---

**Togetherly - Share Food. Share Skills. Build Community.** 🤝
