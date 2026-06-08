# Luxella Spaces - PHP / MySQL

Standalone PHP version (HTML, CSS, JS, PHP, MySQL). Runs on any LAMP host
(cPanel, Hostinger, XAMPP, MAMP, etc.). No Composer, no build step.

## 1. Install

1. Upload the entire folder to your web server (e.g. `public_html/`).
2. Create a MySQL database (e.g. `luxella`) in cPanel / phpMyAdmin.
3. Import **`database.sql`** into that database.
4. Open **`includes/config.php`** and set:
   - `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`
   - `PHONE`, `PHONE_INTL`, `EMAIL_TO`, `LOCATION` (already filled with your details)
   - `BASE_URL` - leave `''` if installed at domain root, otherwise e.g. `'/luxella'`.
5. Make `uploads/` writable: `chmod 775 uploads`.

Visit your domain - the site is live.

## 2. Deploy to Vercel

This project is PHP/MySQL. Vercel does not run PHP by default, so this repo
includes:

- `vercel.json` - configures the community `vercel-php` runtime.
- `api/index.php` - routes Vercel requests back to the existing PHP files.

In Vercel, add these Environment Variables:

```text
DB_HOST=your-mysql-host
DB_PORT=3306
DB_NAME=luxella
DB_USER=your-mysql-user
DB_PASS=your-mysql-password
BASE_URL=/
SITE_PHONE=0776706980
SITE_PHONE_INTL=256776706980
SITE_EMAIL=hello@luxellaspaces.com
SITE_LOCATION=Kampala, Uganda
SITE_DELIVERY=Nationwide delivery across Uganda
```

You must use an external MySQL database that Vercel can reach, then import
`database.sql` into it before opening the deployed site. Good options include
PlanetScale, Aiven, Railway, Render, DigitalOcean Managed MySQL, or any cPanel
MySQL database that allows remote connections from Vercel.

Important Vercel limitation: serverless functions have a read-only project
filesystem at runtime. Product/gallery image uploads to `uploads/` will not
persist on Vercel. For production uploads on Vercel, use external storage such
as Vercel Blob, Cloudinary, S3, or Uploadcare and adapt `admin/_upload.php` to
store files there.

Deploy from the Vercel dashboard or CLI after setting the environment variables:

```bash
vercel --prod
```

## 3. Admin

- URL: `/admin/login.php`
- Default login: **admin@luxellaspaces.com / Admin@123**
- **CHANGE THIS IMMEDIATELY** - run in phpMyAdmin:

```sql
UPDATE admins
SET email = 'you@yourdomain.com',
    password_hash = '$2y$10$REPLACE_WITH_HASH'
WHERE id = 1;
```

Generate a new hash via PHP:
```php
echo password_hash('YourNewPassword', PASSWORD_DEFAULT);
```

Admin lets you:
- Add / hide / delete **products** (with image upload)
- Upload / delete **gallery** images (multi-upload)
- View / delete **leads** captured from the contact form

## 4. File map

```
index.php          Marketing site (hero, about, categories, gallery,
                   services, testimonials, FAQ, contact form)
shop.php           Product catalogue with category filter + WhatsApp inquiry
admin/             Login + Products / Gallery / Leads CRUD
includes/          config.php, header.php, footer.php
assets/css/style.css
assets/js/main.js
assets/images/     Seed photography
uploads/           User-uploaded product & gallery images
database.sql       Schema + seed data + default admin
.htaccess          Disables directory listing, blocks .sql/.md
```

## 5. WhatsApp lead capture

The contact form saves every inquiry into the `leads` table **and then**
redirects the visitor to WhatsApp with a pre-filled message. You never lose
a lead, even if WhatsApp fails to open.

## 6. Local testing

Install XAMPP / MAMP / Laragon, drop the folder into `htdocs/`, import the SQL
into the bundled MySQL, browse to `http://localhost/luxella-php/`.

---
Built for Luxella Spaces, Kampala - Uganda.
