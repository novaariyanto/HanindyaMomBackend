# CRUD Jtldata

Telah dibuat sistem CRUD lengkap untuk model Jtldata dengan fitur-fitur berikut:

## File yang Dibuat/Dimodifikasi

### 1. Controller
- **File**: `app/Http/Controllers/JtldataController.php`
- **Fungsi**: Menangani semua operasi CRUD (Create, Read, Update, Delete)
- **Fitur**:
  - Index dengan DataTables server-side
  - Store untuk menyimpan data baru
  - Show untuk menampilkan detail data
  - Update untuk mengubah data
  - Destroy untuk menghapus data
  - Menggunakan ResponseFormatter untuk konsistensi response

### 2. Routes
- **File**: `routes/web.php`
- **Routes yang ditambahkan**:
  ```php
  Route::get('jtldata', [JtldataController::class, 'index'])->name('jtldata.index');
  Route::post('jtldata', [JtldataController::class, 'store'])->name('jtldata.store');
  Route::get('jtldata/{id}', [JtldataController::class, 'show'])->name('jtldata.show');
  Route::put('jtldata/{id}', [JtldataController::class, 'update'])->name('jtldata.update');
  Route::delete('jtldata/{id}', [JtldataController::class, 'destroy'])->name('jtldata.destroy');
  ```

### 3. View
- **File**: `resources/views/jtldata/index.blade.php`
- **Fitur**:
  - Tabel dengan DataTables untuk menampilkan data
  - Search functionality
  - Modal untuk tambah data
  - Modal untuk edit data
  - Konfirmasi delete dengan SweetAlert
  - Form validation
  - Responsive design

## Struktur Database

Model Jtldata menggunakan tabel `jtl_data` dengan kolom:
- `id` (Primary Key)
- `id_remunerasi_source` (Foreign Key ke tabel remunerasi_source)
- `jumlah_jtl` (Decimal)
- `jumlah_indeks` (Decimal)
- `nilai_indeks` (Decimal)
- `created_at` & `updated_at` (Timestamps)

## Relasi

- **belongsTo**: Jtldata memiliki relasi ke RemunerasiSource melalui `id_remunerasi_source`

## Fitur Utama

### 1. Tampilan Data
- Tabel responsif dengan DataTables
- Server-side processing untuk performa optimal
- Pencarian real-time
- Format angka yang user-friendly
- Menampilkan nama remunerasi source

### 2. Tambah Data
- Modal form dengan validasi
- Dropdown untuk memilih remunerasi source
- Input number dengan step 0.01 untuk angka desimal
- Validasi required untuk semua field

### 3. Edit Data
- Modal form pre-filled dengan data existing
- Validasi yang sama dengan form tambah
- Update data via AJAX

### 4. Hapus Data
- Konfirmasi dengan SweetAlert
- Soft delete untuk keamanan data
- Feedback visual setelah operasi

### 5. Validasi
- Client-side validation dengan HTML5
- Server-side validation dengan Laravel Validator
- Error handling yang user-friendly

## Cara Menggunakan

1. **Akses halaman**: `/jtldata`
2. **Tambah data**: Klik tombol "Tambah Data JTL"
3. **Edit data**: Klik icon pensil pada kolom Opsi
4. **Hapus data**: Klik icon trash pada kolom Opsi
5. **Cari data**: Gunakan search box di atas tabel

## Teknologi yang Digunakan

- **Backend**: Laravel 10 dengan Eloquent ORM
- **Frontend**: Bootstrap 5, jQuery, DataTables
- **AJAX**: Untuk operasi CRUD tanpa reload halaman
- **SweetAlert**: Untuk notifikasi dan konfirmasi
- **Responsive Design**: Mobile-friendly interface

## Testing

Server dapat dijalankan dengan:
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Akses aplikasi di: `http://localhost:8000/jtldata`

## Notes

- Semua operasi menggunakan AJAX untuk user experience yang lebih baik
- Form validation dilakukan di client dan server side
- Response menggunakan ResponseFormatter untuk konsistensi
- Design mengikuti pattern yang sudah ada di aplikasi (referensi dari grade/index.blade.php)
- Menggunakan bahasa Indonesia sesuai permintaan user 