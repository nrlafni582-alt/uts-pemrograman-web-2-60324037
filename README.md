# UTS Pemrograman Web 2

## Identitas Mahasiswa
- Nama : Nurul Afni Khasifa
- NIM  : 60324037

---

## Deskripsi Aplikasi
Aplikasi ini adalah sistem CRUD (Create, Read, Update, Delete) sederhana untuk mengelola data **kategori perpustakaan** menggunakan PHP Native dan MySQL.

Sistem ini dibuat untuk memenuhi tugas UTS dan menerapkan konsep:
- Database MySQL
- CRUD (Create, Read, Update, Delete)
- Prepared Statement (keamanan query)
- Validasi form (server-side validation)
- Tampilan menggunakan Bootstrap 5

---

## Fitur Aplikasi
- Menampilkan data kategori (READ)
- Menambah data kategori (CREATE)
- Mengedit data kategori (UPDATE)
- Menghapus data kategori (DELETE)
- Validasi input lengkap
- Proteksi dari duplikasi data
- Tampilan UI menggunakan Bootstrap

---

## Keterangan
Aplikasi ini adalah sistem manajemen kategori perpustakaan yang dibuat dengan PHP Native dan MySQL. Pengguna dapat menambah, melihat, mengubah, dan menghapus kategori buku melalui antarmuka sederhana.

---

## Cara Instalasi & Menjalankan Aplikasi

### 1. Persiapan Server
Gunakan XAMPP:
- Apache = ON
- MySQL = ON

### 2. Clone Repository
```bash
git clone https://github.com/username/nama-repo.git
```

### 3. Pindahkan Project
Salin folder project ke:
`C:\xampp\htdocs\nama-folder`

### 4. Buat Database
- Buka phpMyAdmin.
- Buat database baru dengan nama:
uts_perpustakaan_60324037
- Import file `.sql` jika tersedia.

### 5. Konfigurasi Database
Buka file:
`config/database.php`

Sesuaikan konfigurasi berikut:

```php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "uts_perpustakaan_60324025";
```

### 6. Jalankan Aplikasi
Buka browser dan akses:

`http://localhost/nama-folder/index.php`

---

## Struktur Folder
`project-folder/`

- `config/`
  - `database.php`
- `database/`
  - `database_backup.sql`
- `index.php`
- `create.php`
- `edit.php`
- `delete.php`
- `README.md`

---

## Link Repository GitHub
https://github.com/lem0nilvs/uts-pemrograman-web-2-60324025.git
