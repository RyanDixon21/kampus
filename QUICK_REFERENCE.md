# Quick Reference - Database & Storage Management

## 🚀 Quick Commands

### Full Reset dengan Data Produksi (One-Liner)

**Windows PowerShell:**
```powershell
php artisan storage:backup backup; php artisan migrate:fresh --seed --seeder=CurrentDataSeeder; php artisan storage:backup restore; php artisan storage:link
```

**Linux/Mac:**
```bash
php artisan storage:backup backup && php artisan migrate:fresh --seed --seeder=CurrentDataSeeder && php artisan storage:backup restore && php artisan storage:link
```

---

## 📦 Storage Management

| Command | Description |
|---------|-------------|
| `php artisan storage:backup backup` | Backup storage files |
| `php artisan storage:backup restore` | Restore storage from backup |
| `php artisan storage:link` | Create symbolic link |

---

## 🗄️ Database Seeding

### Sample Data (Development)
```bash
php artisan migrate:fresh --seed
```

### Production Data
```bash
php artisan migrate:fresh --seed --seeder=CurrentDataSeeder
```

### Seed Only (No Migration)
```bash
# Sample data
php artisan db:seed

# Production data
php artisan db:seed --class=CurrentDataSeeder
```

---

## 🔄 Migration Commands

| Command | Description |
|---------|-------------|
| `php artisan migrate` | Run migrations |
| `php artisan migrate:fresh` | Drop all tables and re-run migrations |
| `php artisan migrate:refresh` | Rollback and re-run migrations |
| `php artisan migrate:status` | Show migration status |
| `php artisan migrate:rollback` | Rollback last migration |

---

## 📊 Data Export (untuk Update Seeder)

```bash
# Settings
php artisan tinker --execute="echo json_encode(\App\Models\Setting::all()->toArray(), JSON_PRETTY_PRINT);"

# Hero Cards
php artisan tinker --execute="echo json_encode(\App\Models\HeroCard::all()->toArray(), JSON_PRETTY_PRINT);"

# News
php artisan tinker --execute="echo json_encode(\App\Models\News::all()->toArray(), JSON_PRETTY_PRINT);"

# Facilities
php artisan tinker --execute="echo json_encode(\App\Models\Facility::all()->toArray(), JSON_PRETTY_PRINT);"

# Tendik
php artisan tinker --execute="echo json_encode(\App\Models\Tendik::all()->toArray(), JSON_PRETTY_PRINT);"
```

---

## 🎯 Common Workflows

### 1. Setup Fresh Environment dengan Data Produksi
```bash
# Clone repository
git clone <repo-url>
cd <project>

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate:fresh --seed --seeder=CurrentDataSeeder

# Setup storage
php artisan storage:link

# Build assets
npm run build
```

### 2. Reset Database (Keep Storage)
```bash
php artisan migrate:fresh --seed --seeder=CurrentDataSeeder
```

### 3. Reset Database + Storage
```bash
php artisan storage:backup backup
php artisan migrate:fresh --seed --seeder=CurrentDataSeeder
php artisan storage:backup restore
php artisan storage:link
```

### 4. Update Seeder dengan Data Terbaru
```bash
# Export data
php artisan tinker --execute="echo json_encode(\App\Models\Setting::all()->toArray(), JSON_PRETTY_PRINT);" > settings.json

# Edit CurrentDataSeeder.php dengan data baru

# Test
php artisan db:seed --class=CurrentDataSeeder

# Commit
git add database/seeders/CurrentDataSeeder.php
git commit -m "Update production data seeder"
```

---

## 🔍 Troubleshooting

### Check Database Connection
```bash
php artisan db:show
```

### Check Migration Status
```bash
php artisan migrate:status
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Optimize
```bash
php artisan optimize
```

### Check Storage Link
```bash
# Windows
dir public\storage

# Linux/Mac
ls -la public/storage
```

---

## 📝 Important Files

| File | Description |
|------|-------------|
| `database/seeders/CurrentDataSeeder.php` | Production data seeder |
| `database/seeders/DatabaseSeeder.php` | Sample data seeder |
| `app/Console/Commands/BackupStorageCommand.php` | Storage backup command |
| `storage/app/public_backup/` | Storage backup location |
| `.env` | Environment configuration |

---

## ⚠️ Important Notes

1. **Always backup** before migrate fresh/refresh
2. **Test in local** before production
3. **Storage backup** is in `storage/app/public_backup/`
4. **Don't commit** storage files to git
5. **CurrentDataSeeder** will truncate tables before seeding

---

## 🆘 Emergency Recovery

### If Database is Corrupted
```bash
php artisan migrate:fresh --seed --seeder=CurrentDataSeeder
```

### If Storage is Lost
```bash
php artisan storage:backup restore
```

### If Everything is Lost
```bash
# Restore from external backup
# Then run:
php artisan storage:backup backup
php artisan migrate:fresh --seed --seeder=CurrentDataSeeder
php artisan storage:backup restore
php artisan storage:link
```

---

## 📚 Documentation

- **Full Guide:** `MIGRATE_WITH_DATA.md`
- **Seeder Docs:** `SEEDER_DOCUMENTATION.md`
- **Current Data Info:** `database/seeders/README_CURRENT_DATA.md`

---

**Last Updated:** 2026-01-05
