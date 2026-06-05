# Deploy Togetherly to Railway 🚂

This app is Docker-ready. Follow these steps to get a live public URL.

---

## Step 1 — Create a Railway account
1. Go to **https://railway.com** and sign up (you can use your GitHub account).
2. Railway may ask to verify with a card; the free trial credit is enough for a demo.

## Step 2 — Create a project from your GitHub repo
1. Click **New Project → Deploy from GitHub repo**.
2. Authorize Railway to access your GitHub, then pick **`SharpWizard/togetherly_app`**.
3. Railway detects the **Dockerfile** and starts building. (It will fail the first deploy until the database + variables are set — that's expected, continue below.)

## Step 3 — Add a MySQL database
1. In your project, click **New → Database → Add MySQL**.
2. Railway creates a MySQL service with its own connection variables.

## Step 4 — Set environment variables on the **app** service
Open your app service → **Variables** tab → add these (use **Raw Editor** and paste):

```
APP_NAME=Togetherly
APP_ENV=production
APP_KEY=base64:+ODNNuRK7E4gHMGKvScS4z8XGGUwIl4dz+9KXBNC7Nk=
APP_DEBUG=false
APP_URL=https://${{RAILWAY_PUBLIC_DOMAIN}}

LOG_CHANNEL=stderr

DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}

SESSION_DRIVER=database
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=public
```

> The `${{MySQL.XXXX}}` syntax references your MySQL service automatically.
> If your MySQL service is named something other than "MySQL", change the prefix to match.

## Step 5 — Generate a public domain
1. App service → **Settings → Networking → Generate Domain**.
2. Railway gives you a URL like `https://togetherly-production.up.railway.app`.

## Step 6 — Redeploy
1. Click **Deploy** (or push any commit). The container will:
   - install dependencies (already baked into the image)
   - run `php artisan migrate --force --seed` (creates tables + demo data)
   - start the server
2. Open your domain — **Togetherly is live!** 🎉

---

## Login on the live site
- **Demo Login** button on the login page, or
- `demo@togetherly.app` / `password`
- Admin: `admin@togetherly.app` / `password`

---

## Notes
- **Uploaded images** (avatars/food photos) use the local disk, which resets on each
  redeploy on Railway. For permanent storage, switch `FILESYSTEM_DISK` to S3 later.
- **`APP_DEBUG=false`** for production. Set it to `true` temporarily if you need to see
  detailed errors while setting things up.
- The `APP_KEY` above was generated for you. Keep it secret (it's only in Railway's
  variables, never committed to GitHub).
- Sessions use the `database` driver so they survive across the single web process.

## Troubleshooting
- **"No application encryption key"** → `APP_KEY` variable missing/typo.
- **DB connection refused** → check the `${{MySQL.*}}` references match your DB service name.
- **500 on first load** → set `APP_DEBUG=true`, redeploy, read the error, then set back to false.
- **Build logs** are under the service's **Deployments** tab.
