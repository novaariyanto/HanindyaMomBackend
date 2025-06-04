# Fitur CRUD Indeks Pegawai (Updated)

Dokumentasi ini menjelaskan fitur tambah, edit, dan hapus untuk tiga jenis indeks pada halaman detail pegawai (`show.blade.php`) menggunakan tabel pivot pegawai.

## Fitur yang Ditambahkan

### 1. Pegawai Struktural
- **Tambah Data**: Modal form untuk menambah relasi pegawai dengan indeks struktural
- **Edit Data**: Modal form untuk mengubah data relasi pegawai struktural
- **Hapus Data**: Konfirmasi hapus dengan SweetAlert

### 2. Pegawai Jasa Tidak Langsung
- **Tambah Data**: Modal form dengan dropdown indeks jasa tidak langsung
- **Edit Data**: Modal form yang pre-filled dengan data existing
- **Hapus Data**: Konfirmasi hapus dengan SweetAlert

### 3. Pegawai Jasa Langsung Non Medis
- **Tambah Data**: Modal form dengan dropdown indeks jasa langsung non medis
- **Edit Data**: Modal form yang pre-filled dengan data existing
- **Hapus Data**: Konfirmasi hapus dengan SweetAlert

## File yang Dimodifikasi/Ditambahkan

### 1. View File
- `resources/views/indeks-pegawai/show.blade.php`
  - Menambahkan tombol "Tambah Data" pada setiap tab
  - Menggunakan AJAX untuk load data secara dinamis
  - Menambahkan 3 modal form untuk CRUD operations
  - Menambahkan JavaScript untuk handle AJAX requests

### 2. API Controllers
- `app/Http/Controllers/Api/PegawaiStrukturalApiController.php`
- `app/Http/Controllers/Api/PegawaiJasaTidakLangsungApiController.php`
- `app/Http/Controllers/Api/PegawaiJasaNonMedisApiController.php`

### 3. Routes
- `routes/api.php` - Menambahkan API routes untuk ketiga controller

## API Endpoints

### Pegawai Struktural
```
GET    /api/pegawai-struktural?pegawai_id={id}    - List data untuk pegawai tertentu
POST   /api/pegawai-struktural                    - Create data
GET    /api/pegawai-struktural/{id}               - Show data
PUT    /api/pegawai-struktural/{id}               - Update data
DELETE /api/pegawai-struktural/{id}               - Delete data
GET    /api/indeks-struktural-options             - Get indeks options
```

### Pegawai Jasa Tidak Langsung
```
GET    /api/pegawai-jasa-tidak-langsung?pegawai_id={id}    - List data untuk pegawai tertentu
POST   /api/pegawai-jasa-tidak-langsung                    - Create data
GET    /api/pegawai-jasa-tidak-langsung/{id}               - Show data
PUT    /api/pegawai-jasa-tidak-langsung/{id}               - Update data
DELETE /api/pegawai-jasa-tidak-langsung/{id}               - Delete data
GET    /api/indeks-jasa-tidak-langsung-options             - Get indeks options
```

### Pegawai Jasa Langsung Non Medis
```
GET    /api/pegawai-jasa-non-medis?pegawai_id={id}    - List data untuk pegawai tertentu
POST   /api/pegawai-jasa-non-medis                    - Create data
GET    /api/pegawai-jasa-non-medis/{id}               - Show data
PUT    /api/pegawai-jasa-non-medis/{id}               - Update data
DELETE /api/pegawai-jasa-non-medis/{id}               - Delete data
GET    /api/indeks-jasa-non-medis-options             - Get indeks options
```

## Cara Penggunaan

### 1. Tambah Data
1. Buka halaman detail pegawai
2. Pilih tab yang diinginkan (Struktural, Jasa Tidak Langsung, atau Jasa Langsung Non Medis)
3. Klik tombol "Tambah Data"
4. Pilih indeks dari dropdown dan isi nilai
5. Klik "Simpan"

### 2. Edit Data
1. Pada tabel data, klik tombol edit (ikon pensil kuning)
2. Modal form akan muncul dengan data yang sudah ter-fill
3. Ubah nilai yang diinginkan
4. Klik "Simpan"

### 3. Hapus Data
1. Pada tabel data, klik tombol hapus (ikon trash merah)
2. Konfirmasi penghapusan pada popup SweetAlert
3. Data akan terhapus jika dikonfirmasi

## Validasi Form

### Pegawai Struktural
- `pegawai_id`: Required, harus exist di tabel pegawai
- `jasa_id`: Required, harus exist di tabel indeks_struktural
- `nilai`: Required, numeric, minimum 0

### Pegawai Jasa Tidak Langsung
- `pegawai_id`: Required, harus exist di tabel pegawai
- `jasa_id`: Required, harus exist di tabel indeks_jasa_tidak_langsung
- `nilai`: Required, numeric, minimum 0

### Pegawai Jasa Langsung Non Medis
- `pegawai_id`: Required, harus exist di tabel pegawai
- `jasa_id`: Required, harus exist di tabel indeks_jasa_langsung_non_medis
- `nilai`: Required, numeric, minimum 0

## Perubahan Utama dari Versi Sebelumnya

1. **Target CRUD**: Sekarang menggunakan tabel pivot `pegawai_*` sebagai target utama operasi
2. **Form Input**: Menggunakan dropdown untuk memilih indeks yang sudah ada
3. **Validasi Duplikasi**: Mencegah duplikasi kombinasi pegawai_id dan jasa_id
4. **Load Data Dinamis**: Semua data di-load via AJAX untuk pengalaman yang lebih smooth
5. **Relasi yang Benar**: Menggunakan relasi Eloquent yang tepat untuk menampilkan data

## Response Format

### Success Response
```json
{
    "success": true,
    "message": "Data berhasil disimpan",
    "data": {
        "id": 1,
        "pegawai_id": 1,
        "jasa_id": 1,
        "nilai": 100.50,
        "created_at": "2024-01-01T00:00:00.000000Z",
        "jasa": {
            "id": 1,
            "nama_jabatan": "Manager",
            "nilai": 100.50
        }
    }
}
```

### Error Response (Duplikasi)
```json
{
    "success": false,
    "message": "Data indeks struktural untuk pegawai ini sudah ada"
}
```

### Error Response (Validasi)
```json
{
    "success": false,
    "message": "Validasi gagal",
    "errors": {
        "jasa_id": ["The jasa id field is required."],
        "nilai": ["The nilai field is required."]
    }
}
```

## Dependencies

- jQuery untuk AJAX requests
- Bootstrap untuk modal components
- SweetAlert2 untuk konfirmasi dialog
- Laravel Eloquent untuk relationship management

## Catatan Pengembangan

1. **Pivot Table Management**: CRUD dilakukan pada tabel pivot dengan proper validation
2. **Dynamic Loading**: Data di-load secara dinamis untuk better performance
3. **Duplicate Prevention**: Sistem mencegah duplikasi kombinasi pegawai dan indeks
4. **Relationship Display**: Data ditampilkan dengan menggunakan Eloquent relationships
5. **Error Handling**: Comprehensive error handling untuk berbagai skenario

## Troubleshooting

### Data tidak muncul
- Pastikan relasi Eloquent sudah benar di model
- Check endpoint API dan parameter yang dikirim
- Pastikan data ada di database

### Dropdown kosong
- Check endpoint options API
- Pastikan data indeks ada di database
- Check JavaScript console untuk error

### Error saat simpan
- Check validasi di controller
- Pastikan foreign key constraint benar
- Check duplicate validation logic 