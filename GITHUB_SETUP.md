# Deploying Togetherly to GitHub

Complete guide to push your Togetherly project to GitHub for live checking and collaboration.

## Prerequisites

- Git installed on your machine
- GitHub account (free at https://github.com)
- Project fully set up locally

---

## Step 1: Create GitHub Repository

1. Go to https://github.com/new
2. Enter repository name: `togetherly_app`
3. Add description: "Share Food. Share Skills. Build Community."
4. Choose **Public** (for live checking)
5. **DO NOT** initialize with README (we have one)
6. Click **Create repository**

You'll see a page with: `https://github.com/YOUR_USERNAME/togetherly_app`

---

## Step 2: Initialize Git in Your Local Project

Open Command Prompt in your project folder:

```bash
cd C:\Users\Tanvir\togetherly_app
git init
```

---

## Step 3: Add Remote Origin

Replace `YOUR_USERNAME` with your GitHub username:

```bash
git remote add origin https://github.com/YOUR_USERNAME/togetherly_app.git
```

Verify:
```bash
git remote -v
```

---

## Step 4: Commit All Files

```bash
git add .
git commit -m "Initial commit: Core Togetherly app with food and skill sharing features"
```

---

## Step 5: Push to GitHub

```bash
git branch -M main
git push -u origin main
```

First time might ask for GitHub login. Use:
- Username: Your GitHub username
- Password: Your GitHub personal access token (if 2FA enabled)

**If you see "Authentication failed":**

1. Generate Personal Access Token:
   - Go to GitHub Settings → Developer settings → Personal access tokens
   - Click "Generate new token (classic)"
   - Give it access to `repo` scope
   - Copy the token

2. When Git asks for password, paste the token

---

## Step 6: Verify on GitHub

Visit: `https://github.com/YOUR_USERNAME/togetherly_app`

You should see all your files and folders uploaded!

---

## Step 7: Add GitHub Pages (Optional - for Documentation)

1. Go to your GitHub repo → Settings
2. Scroll to "GitHub Pages"
3. Select "main" branch
4. Click Save
5. Your README will be visible at: `https://YOUR_USERNAME.github.io/togetherly_app`

---

## Step 8: Create Initial Release (Optional - for Live Checking)

1. Go to GitHub repo → Releases
2. Click "Create a new release"
3. Tag version: `v1.0.0-alpha`
4. Release title: "Togetherly v1.0.0-alpha - Core Features"
5. Add description of features
6. Click "Publish release"

---

## Step 9: Add Important Files

### .gitignore Already Included ✓

The project has `.gitignore` which prevents uploading:
- `/node_modules`
- `/vendor`
- `.env` (with sensitive passwords)
- `storage/logs`
- And other unnecessary files

This keeps repository size small and safe.

---

## Making Changes & Pushing Updates

After making changes locally:

```bash
# Check what changed
git status

# Stage changes
git add .

# Commit changes
git commit -m "Describe what you changed"

# Push to GitHub
git push
```

---

## Inviting Collaborators

1. Go to GitHub repo → Settings → Collaborators
2. Click "Add people"
3. Enter collaborator's GitHub username
4. Send invitation

---

## Continuous Improvement Workflow

### For Development
```bash
git checkout -b feature/new-feature
# Make changes
git add .
git commit -m "Add new feature"
git push -u origin feature/new-feature
# Create Pull Request on GitHub
```

### For Fixes
```bash
git checkout -b fix/bug-name
# Fix the bug
git add .
git commit -m "Fix: Describe the bug fix"
git push -u origin fix/bug-name
# Create Pull Request on GitHub
```

---

## GitHub Features to Use

### 1. **Issues** - Track bugs and features
```
Go to Issues → New Issue
```

### 2. **Projects** - Kanban board for tasks
```
Go to Projects → Create project
Organize tasks: To do → In progress → Done
```

### 3. **Wiki** - Documentation
```
Go to Wiki → Create home page
Add setup guides, API docs, etc.
```

### 4. **Discussions** - Community chat
```
Go to Discussions → New discussion
Great for feedback and planning
```

### 5. **Actions** - Automated CI/CD (Optional)
```
Go to Actions → Set up workflow
Auto-run tests on every push
```

---

## Sharing Your Project

### GitHub Pages
Visit your documentation: `https://YOUR_USERNAME.github.io/togetherly_app`

### Live Demo (Next Steps)
To deploy live, use:
- **Heroku** (free tier)
- **Railway** (paid, better free tier)
- **DigitalOcean** (affordable)
- **AWS Free Tier**

### Share Link
Send to others: `https://github.com/YOUR_USERNAME/togetherly_app`

---

## Repository Best Practices

### Regular Commits
```bash
git commit -m "Clear message about changes"
```

### Good Commit Messages
```
✓ GOOD:
- "Add food expiry time validation"
- "Fix: Prevent duplicate messages"
- "Update README with setup guide"

✗ BAD:
- "changes"
- "fixed stuff"
- "update"
```

### Branches
```bash
# Always work on a branch
git checkout -b feature-name
# Then merge back to main
```

### Keep .env Secret
```
# .env is in .gitignore - DON'T push it
# Share .env.example instead
```

---

## Troubleshooting GitHub

### Issue: "fatal: 'origin' does not appear to be a git repository"

**Solution**:
```bash
git remote add origin https://github.com/YOUR_USERNAME/togetherly_app.git
```

### Issue: "Permission denied (publickey)"

**Solution** (Use HTTPS instead of SSH):
```bash
git remote set-url origin https://github.com/YOUR_USERNAME/togetherly_app.git
```

### Issue: Can't push because of conflicts

**Solution**:
```bash
git pull origin main
# Resolve conflicts manually
git add .
git commit -m "Resolve merge conflicts"
git push
```

### Issue: Want to revert last commit

**Solution**:
```bash
git reset --soft HEAD~1
```

---

## Next: Local Deployment

After pushing to GitHub, you can:

1. **Deploy to a Server**:
   - Buy domain & hosting
   - Upload via FTP or Git
   - Set up MySQL on server
   - Run migrations: `php artisan migrate --force`

2. **Use PaaS (Easier)**:
   - Push to Heroku/Railway
   - They auto-deploy on push
   - Free tier available

3. **Docker Deployment**:
   - Create Dockerfile
   - Deploy to AWS, Digital Ocean, etc.

---

## GitHub Repository Statistics

Once on GitHub, you can see:
- **Commits** - Development history
- **Contributors** - Team members
- **Stars** - Community interest
- **Forks** - Users making copies
- **Insights** - Activity graphs

---

## Security Reminders

✓ **Never commit**:
- `.env` files with real passwords
- Database backups
- API keys or secrets
- `node_modules` or `vendor` folders

✓ **Always use**:
- `.gitignore` (already done)
- `.env.example` (no secrets)
- Environment variables
- GitHub Secrets for CI/CD

---

## Example GitHub README Content

```markdown
# Togetherly 🤝

Share Food. Share Skills. Build Community.

A Laravel app for local communities to share surplus food and teach skills.

## Features
- 🍽️ Food Sharing - Post surplus food, claim items locally
- 💡 Skill Sharing - Teach and learn skills
- 📍 Location-Based - See posts from your neighborhood
- 💬 In-App Messages - Direct communication
- ⭐ Community Ratings - Build trust

## Quick Start
See [SETUP.md](SETUP.md) for detailed installation.

```bash
composer install
npm install
php artisan migrate
npm run dev
php artisan serve
```

Visit: http://localhost:8000

## Tech Stack
- Laravel 10
- MySQL
- Bootstrap 5
- JavaScript

## Contributing
Pull requests welcome! See [GITHUB_SETUP.md](GITHUB_SETUP.md).

## License
MIT License
```

---

## Final Checklist

- [ ] Repository created on GitHub
- [ ] Local project pushed to GitHub
- [ ] .env and secrets NOT in repo
- [ ] README and SETUP guides accessible
- [ ] GitHub Pages enabled (optional)
- [ ] Collaborators added (if team)

---

**Your project is now on GitHub!** 🎉

Next: Consider setting up automatic deployments or live hosting.

Good luck! Feel free to share the GitHub link with others for feedback.
