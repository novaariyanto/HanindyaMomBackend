# Dokumentasi CRUD JTL Pegawai Hasil

## Deskripsi
Sistem CRUD untuk JTL (Jasa Tidak Langsung) Pegawai Hasil adalah fitur yang mengelola data hasil perhitungan remunerasi pegawai berdasarkan indeks yang telah ditetapkan. Sistem ini memungkinkan pengelolaan data pegawai dengan berbagai komponen indeks dan perhitungan otomatis untuk JTL bruto, potongan pajak, dan JTL net.

## Fitur Utama

### 1. CRUD Operations
- **Create**: Menambah data JTL Pegawai Hasil baru
- **Read**: Menampilkan daftar data dengan filter dan pencarian
- **Update**: Mengubah data yang sudah ada
- **Delete**: Menghapus data

### 2. Filter dan Pencarian
- Filter berdasarkan Remunerasi Source
- Filter berdasarkan Unit Kerja
- Pencarian berdasarkan NIK dan Nama Pegawai

### 3. Export Excel
- Export data ke format Excel (.xlsx)
- Menggunakan PhpOffice\PhpSpreadsheet untuk formatting yang lebih baik
- Styling professional dengan header berwarna
- Format mata uang dan persentase
- Zebra striping untuk kemudahan membaca

### 4. View Berdasarkan Remunerasi Source
- Tampilan khusus untuk data berdasarkan remunerasi source tertentu
- Filter dan export sesuai dengan remunerasi source yang dipilih

## Struktur Database

### Tabel: `jtl_pegawai_hasil`
```sql
- id (Primary Key)
- id_pegawai (String, 50) - ID Pegawai
- remunerasi_source (Unsigned Big Integer) - Foreign Key ke tabel remunerasi_source
- nik (String, 20) - NIK Pegawai
- nama_pegawai (String, 255) - Nama Pegawai
- unit_kerja_id (Unsigned Big Integer, Nullable) - Foreign Key ke tabel unit_kerja
- dasar (Decimal 18,2) - Indeks Dasar
- kompetensi (Decimal 18,2) - Indeks Kompetensi
- resiko (Decimal 18,2) - Indeks Resiko
- emergensi (Decimal 18,2) - Indeks Emergensi
- posisi (Decimal 18,2) - Indeks Posisi
- kinerja (Decimal 18,2) - Indeks Kinerja
- jumlah (Decimal 18,2) - Total dari semua indeks (dihitung otomatis)
- nilai_indeks (Decimal 18,2) - Nilai indeks dari jtl_data
- jtl_bruto (Decimal 18,2) - jumlah × nilai_indeks (dihitung otomatis)
- pajak (Decimal 18,2) - Persentase pajak
- potongan_pajak (Decimal 18,2) - Nilai potongan pajak (dihitung otomatis)
- jtl_net (Decimal 18,2) - jtl_bruto - potongan_pajak (dihitung otomatis)
- rekening (String, 50, Nullable) - Nomor rekening
- timestamps (created_at, updated_at)
```

### Relasi
- `belongsTo(RemunerasiSource::class)` - Relasi ke tabel remunerasi_source
- `belongsTo(Pegawai::class)` - Relasi ke tabel pegawai
- `belongsTo(UnitKerja::class)` - Relasi ke tabel unit_kerja

## File-file yang Dibuat/Dimodifikasi

### 1. Model
- `app/Models/JtlPegawaiHasil.php` - Model utama dengan relasi dan auto-calculation

### 2. Controller
- `app/Http/Controllers/JtlPegawaiHasilController.php` - Controller untuk CRUD operations

### 3. Export Class
- `app/Exports/JtlPegawaiHasilExport.php` - Class untuk export Excel menggunakan PhpOffice\PhpSpreadsheet

### 4. Views
- `resources/views/jtl-pegawai-hasil/index.blade.php` - Halaman utama dengan filter semua remunerasi source
- `resources/views/jtl-pegawai-hasil/by-remunerasi-source.blade.php` - Halaman untuk remunerasi source tertentu

### 5. Migration
- `database/migrations/2025_06_18_083553_create_jtl_pegawai_hasils_table.php` - Migration tabel

### 6. Routes
- Ditambahkan routes di `routes/web.php` untuk semua operasi CRUD dan export

## Routes yang Tersedia

```php
// Routes utama
GET    /jtl-pegawai-hasil                 - Index (daftar semua data)
POST   /jtl-pegawai-hasil                 - Store (tambah data baru)
GET    /jtl-pegawai-hasil/{id}           - Show (detail data)
PUT    /jtl-pegawai-hasil/{id}           - Update (ubah data)
DELETE /jtl-pegawai-hasil/{id}           - Destroy (hapus data)

// Export
GET    /jtl-pegawai-hasil/export         - Export Excel

// View berdasarkan Remunerasi Source
GET    /jtl-pegawai-hasil/remunerasi-source/{id} - Data by Remunerasi Source
```

## Fitur Auto-Calculation

Model `JtlPegawaiHasil` memiliki fitur auto-calculation yang akan otomatis menghitung:

1. **Jumlah**: Penjumlahan dari dasar + kompetensi + resiko + emergensi + posisi + kinerja
2. **JTL Bruto**: jumlah × nilai_indeks
3. **Potongan Pajak**: (pajak / 100) × jtl_bruto
4. **JTL Net**: jtl_bruto - potongan_pajak

Perhitungan ini dilakukan otomatis setiap kali data disimpan (create/update).

## Validasi

### Data yang Divalidasi:
- id_pegawai: required, harus ada di tabel pegawai
- remunerasi_source: required, harus ada di tabel remunerasi_source
- nik: required, string, maksimal 50 karakter
- nama_pegawai: required, string, maksimal 255 karakter
- unit_kerja_id: required, harus ada di tabel unit_kerja
- dasar, kompetensi, resiko, emergensi, posisi, kinerja: required, numeric, 0-99999999.99
- nilai_indeks: required, numeric, 0-99999999.99
- pajak: optional, numeric, 0-100
- rekening: optional, string, maksimal 50 karakter

### Validasi Unik:
- Kombinasi id_pegawai + remunerasi_source harus unik (tidak boleh duplikat)

## Fitur Export Excel

Export Excel menggunakan PhpOffice\PhpSpreadsheet dengan fitur:

### Styling Professional:
- Header dengan background biru (#4472C4) dan teks putih
- Border pada semua cell
- Zebra striping untuk baris data
- Auto-sizing kolom dengan minimum width untuk kolom penting

### Format Data:
- Kolom angka: Format dengan separator ribuan dan 2 desimal
- Kolom mata uang (JTL Bruto, Potongan Pajak, JTL Net): Format Rupiah
- Kolom pajak: Format persentase
- Alignment yang sesuai (kanan untuk angka, tengah untuk nomor)

### Properties Document:
- Title: "Data JTL Pegawai Hasil"
- Creator: "Sistem Remunerasi"
- Subject dan Description yang sesuai

## Cara Penggunaan

### 1. Akses Halaman Utama
```
/jtl-pegawai-hasil
```

### 2. Tambah Data Baru
- Klik tombol "Tambah JTL Pegawai Hasil"
- Pilih pegawai (akan auto-fill NIK, nama, dan unit kerja)
- Pilih remunerasi source
- Isi nilai indeks dan komponen indeks
- Isi pajak dan rekening (opsional)
- Klik "Simpan"

### 3. Edit Data
- Klik tombol edit (ikon pensil) pada data yang ingin diubah
- Ubah data sesuai kebutuhan
- Klik "Update"

### 4. Hapus Data
- Klik tombol hapus (ikon trash) pada data yang ingin dihapus
- Konfirmasi penghapusan

### 5. Export Excel
- Atur filter sesuai kebutuhan (opsional)
- Klik tombol "Export Excel"
- File akan diunduh otomatis

### 6. Filter Data
- **Remunerasi Source**: Filter berdasarkan sumber remunerasi
- **Unit Kerja**: Filter berdasarkan unit kerja
- **Pencarian**: Cari berdasarkan NIK atau nama pegawai

### 7. View by Remunerasi Source
```
/jtl-pegawai-hasil/remunerasi-source/{id}
```
Untuk melihat data spesifik untuk satu remunerasi source tertentu.

## Integrasi dengan Sistem

### Dependencies:
- Model `Pegawai` untuk data pegawai
- Model `RemunerasiSource` untuk sumber remunerasi
- Model `UnitKerja` untuk unit kerja
- DataTables untuk tampilan tabel dengan pagination dan sorting
- SweetAlert2 untuk notifikasi dan konfirmasi
- Bootstrap modal untuk form input
- PhpOffice\PhpSpreadsheet untuk export Excel

### JavaScript Libraries:
- jQuery untuk AJAX operations
- DataTables untuk table functionality
- SweetAlert2 untuk notifications
- Bootstrap untuk modal dan styling

## Keamanan

- Semua routes dilindungi middleware `auth`
- Validasi input pada level controller
- CSRF protection untuk semua form submission
- Foreign key constraints untuk data integrity
- Soft validation untuk mencegah duplicate data

## Performance

- Index pada kolom yang sering dicari (id_pegawai, remunerasi_source)
- Eager loading untuk relasi (with())
- Server-side processing untuk DataTables
- Efficient query building dengan conditional where clauses
- StreamedResponse untuk export file besar

## Maintenance

### Untuk menambah field baru:
1. Tambah kolom di migration
2. Update model (fillable, casts, validation)
3. Update controller (validation rules)
4. Update view (form fields, table columns)
5. Update export class (headers, data mapping)

### Untuk mengubah perhitungan:
1. Update method di model `JtlPegawaiHasil`
2. Update view jika perlu menampilkan informasi perhitungan
3. Update export class jika format berubah 