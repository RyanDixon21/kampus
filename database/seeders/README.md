# Database Seeders

This directory contains seeders for populating the database with initial and sample data.

## Available Seeders

### 1. AdminUserSeeder
Creates a default admin user for accessing the admin panel.

**Credentials:**
- Email: `admin@sttpratama.ac.id`
- Password: `password`

⚠️ **Important:** Change the password after first login!

### 2. SettingsSeeder
Seeds default settings for the university website including:
- University name and contact information
- Social media URLs
- WhatsApp admin number
- Registration fee and CBT settings

### 3. SampleDataSeeder (Optional)
Seeds sample data for testing purposes:
- 5 news articles (4 published, 1 draft)
- 6 facilities
- 5 tendik (staff members)

## Usage

### Seed All Data
To run all seeders (admin user + settings):
```bash
php artisan db:seed
```

### Seed Individual Seeders
To run specific seeders:
```bash
php artisan db:seed --class=AdminUserSeeder
php artisan db:seed --class=SettingsSeeder
php artisan db:seed --class=SampleDataSeeder
```

### Fresh Migration with Seeding
To reset the database and seed all data:
```bash
php artisan migrate:fresh --seed
```

## Enabling Sample Data

By default, sample data seeding is commented out in `DatabaseSeeder.php`. To enable it:

1. Open `database/seeders/DatabaseSeeder.php`
2. Uncomment the `SampleDataSeeder::class` line
3. Run `php artisan db:seed`

## Notes

- **Settings**: After seeding, update the logo, contact information, and WhatsApp admin number through the admin panel
- **Sample Data**: The sample data uses placeholder image paths. You'll need to upload actual images through the admin panel
- **Admin User**: The seeder uses `updateOrCreate` so it's safe to run multiple times without creating duplicates
