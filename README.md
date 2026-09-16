# Aplikasi Inventaris Sekolah — Laravel

Paket ini berisi seluruh file kode (migration, model, controller, middleware,
route, view Blade, CSS) untuk aplikasi Web Inventaris Sekolah dengan
Public Interface (read-only) dan Admin Interface (CRUD, dilindungi login).

## Cara Pakai

### 1. Buat project Laravel baru
```bash
composer create-project laravel/laravel inventaris-sekolah
cd inventaris-sekolah
```

### 2. Salin seluruh isi folder paket ini ke dalam project
Timpa/salin folder & file berikut ke lokasi yang sama pada project Laravel Anda:

```
app/Models/Inventaris.php
app/Http/Controllers/HomeController.php
app/Http/Controllers/InventarisController.php
app/Http/Controllers/Admin/DashboardController.php
app/Http/Controllers/Admin/InventarisController.php
app/Http/Controllers/Auth/AdminLoginController.php
app/Http/Middleware/EnsureUserIsAdmin.php
app/Http/Requests/StoreInventarisRequest.php
app/Http/Requests/UpdateInventarisRequest.php
database/migrations/2024_01_01_000000_add_is_admin_to_users_table.php
database/migrations/2024_01_01_000001_create_inventaris_table.php
database/factories/InventarisFactory.php
database/seeders/InventarisSeeder.php
database/seeders/AdminUserSeeder.php
database/seeders/DatabaseSeeder.php
routes/web.php
resources/views/layouts/public.blade.php
resources/views/layouts/admin.blade.php
resources/views/public/home.blade.php
resources/views/public/inventaris/index.blade.php
resources/views/public/inventaris/show.blade.php
resources/views/admin/dashboard.blade.php
resources/views/admin/inventaris/index.blade.php
resources/views/admin/inventaris/create.blade.php
resources/views/admin/inventaris/edit.blade.php
resources/views/admin/inventaris/show.blade.php
resources/views/admin/inventaris/_form.blade.php
resources/views/auth/login.blade.php
public/css/app.css
```

### 3. Registrasi middleware `admin`

**Laravel 11+** — edit `bootstrap/app.php`:
```php
use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Foundation\Configuration\Middleware;

->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => EnsureUserIsAdmin::class,
    ]);
})
```

**Laravel 10** — edit `app/Http/Kernel.php`, tambahkan pada `$middlewareAliases`:
```php
'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
```

### 4. Konfigurasi database
Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inventaris_sekolah
DB_USERNAME=root
DB_PASSWORD=
```
Buat database: `mysql -u root -e "CREATE DATABASE inventaris_sekolah"`

### 5. Migration & Seeder
```bash
php artisan migrate
php artisan db:seed
```
Ini akan membuat:
- Tabel `users` (dengan kolom tambahan `is_admin`)
- Tabel `inventaris`
- 1 akun admin: **admin@sekolah.test** / **password123**
- 40 data dummy inventaris

### 6. Jalankan server
```bash
php artisan serve
```

## Pengujian Manual (Checklist)

| # | Skenario | Cara Uji | Hasil yang Diharapkan |
|---|----------|----------|------------------------|
| 1 | Akses publik | Buka `/` tanpa login | Beranda muncul, tanpa tombol CRUD |
| 2 | Daftar inventaris | Buka `/inventaris` | Tabel data + search + filter + pagination |
| 3 | Search | Isi kata kunci di kolom cari | Data terfilter sesuai nama barang |
| 4 | Filter jenis | Pilih salah satu jenis barang | Data terfilter sesuai jenis |
| 5 | Detail barang | Klik "Detail" pada salah satu baris | Halaman detail muncul, read-only |
| 6 | Akses admin tanpa login | Buka `/admin` langsung | Diarahkan ke halaman login |
| 7 | Login gagal | Isi email/password salah | Pesan error validasi muncul |
| 8 | Login sukses | Gunakan admin@sekolah.test / password123 | Masuk ke dashboard admin |
| 9 | Dashboard | Lihat halaman `/admin` | Statistik total barang, jenis, kondisi baik/rusak |
| 10 | Tambah barang | `/admin/inventaris/create`, isi form, submit | Data tersimpan, redirect dengan notifikasi sukses |
| 11 | Validasi form | Submit form kosong | Pesan error di setiap field wajib |
| 12 | Edit barang | Klik "Edit" pada salah satu baris | Form terisi data lama, submit memperbarui data |
| 13 | Hapus barang | Klik "Hapus" | Modal konfirmasi muncul sebelum data dihapus |
| 14 | Logout | Klik tombol logout | Sesi berakhir, diarahkan ke halaman login |
| 15 | Proteksi non-admin | Buat user biasa (is_admin=false), login | Ditolak masuk ke `/admin`, dikembalikan ke login |

## Struktur Route

```
GET  /                              -> home
GET  /inventaris                    -> inventaris.index (public, read-only)
GET  /inventaris/{id}                -> inventaris.show (public, read-only)

GET  /admin/login                   -> admin.login
POST /admin/login                   -> admin.login.store
POST /admin/logout                  -> admin.logout

GET    /admin                        -> admin.dashboard      [middleware: admin]
GET    /admin/inventaris             -> admin.inventaris.index
GET    /admin/inventaris/create      -> admin.inventaris.create
POST   /admin/inventaris             -> admin.inventaris.store
GET    /admin/inventaris/{id}        -> admin.inventaris.show
GET    /admin/inventaris/{id}/edit   -> admin.inventaris.edit
PUT    /admin/inventaris/{id}        -> admin.inventaris.update
DELETE /admin/inventaris/{id}        -> admin.inventaris.destroy
```

## Catatan Keamanan yang Sudah Diterapkan
- CSRF protection otomatis via `@csrf` di setiap form.
- Mass assignment protection via `$fillable` pada model `Inventaris`.
- Validasi input di sisi server via Form Request (`StoreInventarisRequest`, `UpdateInventarisRequest`).
- Password admin di-hash otomatis oleh Laravel (`Hash::make`).
- Route admin diamankan middleware `admin`; user non-admin otomatis di-logout & diarahkan ke halaman login.
- Konfirmasi modal sebelum penghapusan data agar tidak terhapus tidak sengaja.

## Pengembangan Lanjutan (Opsional)
- Tambah role granular (super admin, staf) jika kebutuhan bertambah.
- Tambah upload foto barang (`Storage::disk('public')`).
- Tambah export data ke Excel/PDF (`laravel-excel`, `dompdf`).
- Tambah log aktivitas CRUD (`spatie/laravel-activitylog`).
# inventaris_sekolah
