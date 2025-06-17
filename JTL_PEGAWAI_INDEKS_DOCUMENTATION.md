# CRUD JTL Pegawai Indeks - Dokumentasi Lengkap

## Overview
CRUD lengkap untuk mengelola data indeks pegawai JTL (Jasa Tidak Langsung) dengan fitur auto-calculate total dan interface yang user-friendly.

## File yang Telah Dibuat

### 1. Model: JtlPegawaiIndeks.php
```php
app/Models/JtlPegawaiIndeks.php
```
- Relasi ke tabel Pegawai
- Auto-calculate field `jumlah`
- Type casting untuk decimal fields

### 2. Controller: JtlPegawaiIndeksController.php  
```php
app/Http/Controllers/JtlPegawaiIndeksController.php
```
- Full CRUD operations
- Validasi komprehensif
- DataTables integration

### 3. View: index.blade.php
```php
resources/views/jtl-pegawai-indeks/index.blade.php
```
- Responsive DataTables
- Modal forms (Create/Edit)
- AJAX operations
- SweetAlert notifications

### 4. Migration: create_jtl_pegawai_indeks_table.php
```php
database/migrations/2025_01_09_000000_create_jtl_pegawai_indeks_table.php
```

### 5. Routes (ditambahkan ke web.php)
```php
// JTL Pegawai Indeks Routes
Route::get('jtl-pegawai-indeks', [JtlPegawaiIndeksController::class, 'index']);
Route::post('jtl-pegawai-indeks', [JtlPegawaiIndeksController::class, 'store']);
Route::get('jtl-pegawai-indeks/{id}', [JtlPegawaiIndeksController::class, 'show']);
Route::put('jtl-pegawai-indeks/{id}', [JtlPegawaiIndeksController::class, 'update']);
Route::delete('jtl-pegawai-indeks/{id}', [JtlPegawaiIndeksController::class, 'destroy']);
```

## Struktur Database

### Tabel: jtl_pegawai_indeks
```sql
- id (bigint, auto_increment, primary key)
- id_pegawai (varchar 50, indexed)
- dasar (decimal 18,2, default 0.00)
- kompetensi (decimal 18,2, default 0.00)  
- resiko (decimal 18,2, default 0.00)
- emergensi (decimal 18,2, default 0.00)
- posisi (decimal 18,2, default 0.00)
- kinerja (decimal 18,2, default 0.00)
- jumlah (decimal 18,2, default 0.00) // auto calculated
- created_at (timestamp)
- updated_at (timestamp)
```

## Fitur Utama

### 1. Auto Calculate Total
Field `jumlah` otomatis dihitung dari penjumlahan:
dasar + kompetensi + resiko + emergensi + posisi + kinerja

### 2. Validasi Lengkap
- Semua field numeric wajib diisi
- Range 0 - 99,999,999.99
- Pegawai tidak boleh duplikat
- Foreign key validation

### 3. Interface Modern
- DataTables dengan server-side processing
- Modal forms yang responsive
- Real-time search
- Loading indicators
- SweetAlert notifications

## Cara Penggunaan

### 1. Instalasi
```bash
# Jalankan migration
php artisan migrate

# Akses halaman
http://localhost/jtl-pegawai-indeks
```

### 2. Operasi CRUD

#### Create (Tambah Data)
1. Klik tombol "Tambah Indeks Pegawai"
2. Pilih pegawai dari dropdown
3. Isi nilai untuk setiap field
4. Klik "Simpan"
5. Total akan dihitung otomatis

#### Read (Lihat Data) 
- Data ditampilkan dalam tabel dengan pagination
- Gunakan search box untuk mencari data
- Kolom "Total" menampilkan hasil perhitungan otomatis

#### Update (Edit Data)
1. Klik tombol edit (ikon pensil)
2. Modal edit akan terbuka dengan data existing
3. Ubah nilai yang diperlukan
4. Klik "Update"

#### Delete (Hapus Data)
1. Klik tombol delete (ikon trash)
2. Konfirmasi penghapusan
3. Data akan dihapus permanent

## Teknologi yang Digunakan

- **Backend**: Laravel Framework
- **Database**: MySQL (decimal fields)
- **Frontend**: Bootstrap, jQuery
- **DataTables**: Server-side processing
- **Notifications**: SweetAlert2
- **Icons**: Tabler Icons

## Keamanan

- CSRF protection
- Input validation & sanitization  
- SQL injection protection (Eloquent ORM)
- XSS protection
- User authentication required

## API Response Format

### Success
```json
{
    "meta": {
        "code": 200,
        "status": "success", 
        "message": "Data berhasil disimpan"
    },
    "data": { ... }
}
```

### Error
```json
{
    "meta": {
        "code": 422,
        "status": "error",
        "message": "Validasi gagal"
    },
    "data": {
        "field_name": ["Error message"]
    }
}
```

## URL Endpoints

- `GET /jtl-pegawai-indeks` - Halaman utama & data AJAX
- `POST /jtl-pegawai-indeks` - Create data
- `GET /jtl-pegawai-indeks/{id}` - Show specific data  
- `PUT /jtl-pegawai-indeks/{id}` - Update data
- `DELETE /jtl-pegawai-indeks/{id}` - Delete data

## Prerequisites

1. Tabel `pegawai` harus sudah ada dan terisi
2. Model Pegawai harus sudah dibuat dengan relasi yang benar
3. Helper ResponseFormatter harus tersedia
4. DataTables package harus terinstall

## Troubleshooting

### Error: Table doesn't exist
```bash
php artisan migrate
```

### Error: Class not found
Pastikan import controller sudah ditambahkan di routes/web.php:
```php
use App\Http\Controllers\JtlPegawaiIndeksController;
```

### Error: Pegawai tidak ditemukan
Pastikan tabel pegawai sudah terisi dan field `id` sesuai dengan yang direferensikan.

---

**Catatan**: CRUD ini mengikuti pola dan struktur yang sama dengan modul Grade yang sudah ada, sehingga konsisten dengan arsitektur aplikasi. 