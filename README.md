# Aplikasi CRUD Data Produk

## Deskripsi Aplikasi

Aplikasi CRUD Data Produk merupakan aplikasi berbasis PHP Native yang digunakan untuk mengelola informasi produk. Aplikasi ini menerapkan arsitektur Model-View-Controller (MVC) agar kode program lebih terstruktur dan mudah dikembangkan.

## Kebutuhan Sistem

- PHP 8.0 atau lebih baru
- MySQL/MariaDB
- Laragon sebagai lingkungan server lokal
- Browser web
- Git untuk mengelola versi kode program

## Instalasi dan Konfigurasi

1. Simpan folder proyek `mvc-produk` di direktori `C:\laragon\www\`.
2. Jalankan Apache dan MySQL melalui Laragon.
3. Impor file `database/produk.sql` ke database MySQL.
4. Periksa pengaturan koneksi database pada `config/database.php`.
5. Pastikan database `db_produk` berhasil terhubung dengan aplikasi.

## Struktur Folder

- `app/models/` berisi kode untuk mengelola data produk.
- `app/controllers/` menangani proses dan permintaan pengguna.
- `app/views/` berisi tampilan halaman aplikasi.
- `config/` menyimpan konfigurasi koneksi database.
- `database/` menyimpan file SQL untuk pembuatan tabel dan data awal.
- `public/` berisi halaman utama yang diakses melalui browser.

## Fitur Aplikasi

- Menampilkan daftar produk.
- Menambahkan produk baru.
- Mengedit informasi produk.
- Menghapus produk.
- Memvalidasi data sebelum disimpan.

## Cara Menjalankan Aplikasi

Setelah server dan database aktif, buka browser dan akses alamat berikut:

`http://localhost/mvc-produk/public/`

## Histori Pengembangan Git

Pengembangan aplikasi dilakukan secara bertahap menggunakan Git. Setiap perubahan penting disimpan dalam commit agar proses pengembangan dapat ditelusuri.

Untuk melihat riwayat pengembangan, gunakan perintah:

`git log --oneline --graph --decorate`

