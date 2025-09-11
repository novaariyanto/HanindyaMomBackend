## HanindyaMom Backend

Backend aplikasi untuk pelacakan aktivitas dan pertumbuhan bayi (feeding, diaper, sleep, growth, vaccines, milestones, nutrition). Proyek ini menyediakan Admin Panel modern berbasis DataTables dengan CRUD via modal (AJAX) serta API Mobile v1 berautentikasi Laravel Sanctum.

### Fitur Utama
- Admin Panel: Babies, Users, Feeding, Diapers, Sleep, Growth, Vaccines (DataTables server-side + CRUD modal AJAX)
- Upload foto user (via Admin & API `/api/v1/me`) dan nutrition (multipart atau URL)
- API v1 (mobile): auth, profil, babies, feeding, diapers, sleep, growth, vaccines, milestones, nutrition, settings, timeline, dashboard
- RBAC (Spatie Permissions) dan autentikasi API menggunakan Laravel Sanctum

### Teknologi / Stack
- Laravel ^12.0
- PHP ^8.2
- MySQL/MariaDB
- Laravel Sanctum, Spatie/laravel-permission, Yajra DataTables
- Vite/Web tooling (sesuaikan dengan konfigurasi proyek)

## Struktur Direktori Penting
- `app/Http/Controllers` (Admin, Api, Api/V1)
- `app/Models` (BabyProfile, FeedingLog, DiaperLog, SleepLog, GrowthLog, VaccineSchedule, Milestone, NutritionEntry, User)
- `routes/web.php`, `routes/api.php`
- `resources/views/admin/...`
- `public/uploads/users`, `public/uploads/nutrition`

## Prasyarat
- PHP 8.2+, Composer, Node.js & npm, MySQL/MariaDB
- Ekstensi PHP umum: pdo, mbstring (gd jika diperlukan)
- File `.env` dengan konfigurasi: `DB_*`, `APP_URL`, setelan Sanctum

## Instalasi & Setup
Langkah awal:

```bash
composer install
cp .env.example .env   # atau sesuai script post-root
php artisan key:generate
# buat database, set .env DB_*
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

Opsional (aset frontend jika dipakai):

```bash
npm install
npm run dev
```

## Autentikasi & Role
- Laravel Sanctum untuk Bearer Token (API)
- Token didapat melalui endpoint auth v1 (login/register)
- Spatie/laravel-permission: role “admin” (tetapkan via seeder/panel sesuai kebutuhan)

## Menjalankan Aplikasi
- Development server: `php artisan serve`
- Admin Panel: `http://127.0.0.1:8000/` (login, lalu navigasi menu)
- Penyimpanan upload: `public/uploads/users`, `public/uploads/nutrition`
- Izin folder: pastikan direktori upload dapat ditulis

## Ringkasan API v1
- Format sukses: `{ success, message, data }`
- Autentikasi: Bearer Token (Sanctum)
- Endpoint penting (ringkas):
  - Auth: `/api/v1/auth/login`, `/api/v1/auth/register`, `/api/v1/auth/logout`
  - Profil: `/api/v1/me` (GET/PUT; dukung `photo` string & `photo_file`)
  - Babies: CRUD (`/api/v1/babies`)
  - Feeding: `GET /api/v1/feeding?baby_id=...`, `POST /api/v1/feeding`, `GET|PUT|DELETE /api/v1/feeding/{id}`
  - Diapers: endpoint `/api/v1/diapers` (list via `baby_id`; detail by `{id}`)
  - Sleep: endpoint `/api/v1/sleep`
  - Growth: endpoint `/api/v1/growth`
  - Vaccines: endpoint `/api/v1/vaccines`
  - Milestones: endpoint `/api/v1/milestones`
  - Nutrition: endpoint `/api/v1/nutrition` (upload via `photo_file` atau `photo` URL)
  - Settings: `/api/v1/settings` (GET/PUT)
  - Timeline: `/api/v1/timeline?baby_id=...`
  - Dashboard: `/api/v1/dashboard`

> Penting: semua detail/update/delete menggunakan `{id}` = UUID (36 char), bukan timestamp.

## Contoh Request (cURL)
Profil:

```bash
curl -H "Authorization: Bearer <TOKEN>" http://127.0.0.1:8000/api/v1/me
```

Update profil (JSON):

```bash
curl -X PUT -H "Authorization: Bearer <TOKEN>" -H "Content-Type: application/json" \
-d '{"name":"Nama Baru","email":"email@contoh.com","photo":"uploads/users/user_1.jpg"}' \
http://127.0.0.1:8000/api/v1/me
```

Update profil (multipart):

```bash
curl -X PUT -H "Authorization: Bearer <TOKEN>" \
-F "name=Nama Baru" -F "photo_file=@/path/foto.jpg" \
http://127.0.0.1:8000/api/v1/me
```

Feeding list:

```bash
curl -H "Authorization: Bearer <TOKEN>" "http://127.0.0.1:8000/api/v1/feeding?baby_id=<UUID_BAYI>"
```

Feeding delete (pakai UUID dari list):

```bash
curl -X DELETE -H "Authorization: Bearer <TOKEN>" http://127.0.0.1:8000/api/v1/feeding/<UUID_LOG>
```

Nutrition create (multipart):

```bash
curl -X POST -H "Authorization: Bearer <TOKEN>" \
-F "baby_id=<UUID_BAYI>" -F "time=2025-09-10T10:00:00" -F "title=Bubur Tim" \
-F "notes=tanpa garam" -F "photo_file=@/path/foto-menu.jpg" \
http://127.0.0.1:8000/api/v1/nutrition
```

## Catatan Penting
- Path foto relatif → bangun URL absolut dengan `APP_URL` di frontend
- ID path param = UUID (36 char)
- Batas ukuran upload foto ~2MB
- Gunakan ISO8601 untuk datetime

## Testing

```bash
php artisan test
```

- Minimal uji: CRUD tiap modul & autentikasi

## Deployment
- Checklist: `APP_ENV=production`, `php artisan config:cache`, `route:cache`, `view:cache`, `storage:link`, peran queue bila ada, optimasi autoload

## Lisensi / Kredit
- MIT (lihat `composer.json`)
- Kredit: Laravel, Sanctum, Spatie, Yajra DataTables

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
