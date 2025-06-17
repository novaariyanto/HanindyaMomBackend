# Guide Import Excel - JTL Pegawai Indeks

## Overview
Fitur import Excel memungkinkan pengguna untuk mengimpor data indeks pegawai JTL secara massal melalui file Excel (.xlsx atau .xls).

## Cara Penggunaan

### 1. Download Template
- Klik tombol **"Download Template"** untuk mengunduh template Excel
- Template berisi format kolom dan contoh data yang benar
- File template: `template_jtl_pegawai_indeks.xlsx`

### 2. Isi Data di Template
Template memiliki kolom sebagai berikut:
- **Kolom A**: NIK Pegawai (wajib)
- **Kolom B**: Dasar (angka decimal)
- **Kolom C**: Kompetensi (angka decimal)
- **Kolom D**: Resiko (angka decimal)
- **Kolom E**: Emergensi (angka decimal)
- **Kolom F**: Posisi (angka decimal)
- **Kolom G**: Kinerja (angka decimal)

### 3. Upload File
- Klik tombol **"Import Excel"**
- Pilih file Excel yang telah diisi
- Klik **"Import"** untuk memproses data

## Aturan dan Validasi

### Format File
- Format yang diizinkan: `.xlsx` atau `.xls`
- Ukuran maksimal: 2MB
- Gunakan template yang disediakan

### Validasi Data
1. **NIK Pegawai**: 
   - Harus diisi
   - Harus sesuai dengan NIK pegawai yang ada di database

2. **Semua nilai indeks**:
   - Harus berupa angka (decimal)
   - Minimum: 0.00
   - Maksimum: 99,999,999.99

### Aturan Import
- Jika NIK pegawai sudah ada, data akan **diupdate**
- Jika NIK pegawai belum ada, data akan **ditambahkan** sebagai record baru
- Total indeks akan **dihitung otomatis** oleh sistem
- Baris kosong akan diabaikan

## Hasil Import

### Notifikasi Sukses
Jika semua data berhasil diimpor:
- Tampil notifikasi sukses dengan jumlah data yang berhasil diimpor
- Data langsung tampil di tabel

### Notifikasi dengan Warning
Jika ada data yang gagal:
- Tampil dialog dengan detail hasil import
- Menampilkan jumlah data berhasil dan gagal
- Menampilkan detail error untuk 5 baris pertama yang gagal
- Data yang berhasil tetap tersimpan

### Notifikasi Error
Jika import gagal total:
- Tampil notifikasi error dengan pesan kesalahan
- Tidak ada data yang tersimpan

## Contoh Template

| NIK Pegawai      | Dasar   | Kompetensi | Resiko  | Emergensi | Posisi  | Kinerja |
|------------------|---------|------------|---------|-----------|---------|---------|
| 1234567890123456 | 1000.00 | 800.00     | 500.00  | 300.00    | 700.00  | 600.00  |

## Tips Penggunaan

1. **Persiapan Data**: Pastikan semua NIK pegawai sudah terdaftar di sistem
2. **Format Angka**: Gunakan titik (.) sebagai pemisah desimal
3. **Kosongkan Baris**: Jangan biarkan ada baris yang setengah terisi
4. **Backup Data**: Lakukan backup sebelum import data besar
5. **Test Import**: Coba import dengan data kecil terlebih dahulu

## Error Umum dan Solusi

### "Pegawai dengan NIK XXX tidak ditemukan"
**Solusi**: Pastikan NIK sesuai dengan data di database pegawai

### "Nilai harus berupa angka"
**Solusi**: Periksa format angka, gunakan titik (.) sebagai pemisah desimal

### "File tidak dapat dibaca"
**Solusi**: 
- Pastikan file format Excel (.xlsx/.xls)
- File tidak corrupt/rusak
- Ukuran file tidak melebihi 2MB

### "Terjadi kesalahan saat menyimpan data"
**Solusi**: 
- Periksa apakah ada data duplikasi
- Pastikan koneksi database stabil
- Coba import dengan batch lebih kecil

## Fitur Teknis

### Validation Rules
```php
'id_pegawai' => 'required|string'
'dasar' => 'required|numeric|min:0|max:99999999.99'
'kompetensi' => 'required|numeric|min:0|max:99999999.99'
'resiko' => 'required|numeric|min:0|max:99999999.99'
'emergensi' => 'required|numeric|min:0|max:99999999.99'
'posisi' => 'required|numeric|min:0|max:99999999.99'
'kinerja' => 'required|numeric|min:0|max:99999999.99'
```

### Update vs Insert Logic
- System akan mencari record berdasarkan `id_pegawai`
- Jika ditemukan: **UPDATE** record existing
- Jika tidak ditemukan: **INSERT** record baru

### Auto Calculate
- Field `jumlah` dihitung otomatis oleh Model
- Formula: `dasar + kompetensi + resiko + emergensi + posisi + kinerja`

## API Endpoints

### Import Data
```
POST /jtl-pegawai-indeks/import
Content-Type: multipart/form-data
Parameter: file (Excel file)
```

### Download Template
```
GET /jtl-pegawai-indeks/template/download
Response: Excel file download
```

## Logs dan Monitoring

System akan mencatat:
- Jumlah data yang berhasil diimpor
- Jumlah data yang gagal diimpor
- Detail error untuk setiap baris yang gagal
- Waktu proses import

Gunakan fitur ini untuk monitoring dan troubleshooting import data. 