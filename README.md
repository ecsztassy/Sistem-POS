# Ritel POS

Aplikasi kasir retail berbahasa Indonesia dengan Laravel 12, PHP 8.2+, MySQL/InnoDB, Breeze, Blade, Bootstrap 5, Alpine.js, DataTables, FontAwesome, Laravel Excel, dan Dompdf. Zona waktu aplikasi: Asia/Jakarta. Semua nominal disimpan sebagai integer rupiah.

## Menjalankan aplikasi

Persyaratan: PHP 8.2+ beserta ekstensi Laravel, `pdo_mysql`, `pdo_sqlite` untuk pengujian, `gd`, `zip`, `mbstring`, dan `xml`; Composer; Node.js yang mendukung Vite 7; MySQL aktif.

```powershell
composer install
npm.cmd install
```

Jika `.env` belum ada, salin `.env.example` ke `.env`, lalu jalankan `php artisan key:generate`. Atur koneksi database dan buat database MySQL kosong bernama `db_pos_kasir`. Untuk checkout ini, koneksi `.env` yang sudah tersedia dipertahankan.

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_pos_kasir
DB_USERNAME=root
DB_PASSWORD=
```

```powershell
php artisan migrate --seed
npm.cmd run build
php artisan serve
```

Buka http://127.0.0.1:8000. Di macOS/Linux, gunakan `npm` untuk perintah `npm.cmd` di dokumentasi ini. Saat mengembangkan antarmuka, jalankan `npm.cmd run dev` di terminal kedua sebagai pengganti build berulang.

## Akun contoh lokal

| Peran | Username | Kata sandi |
| --- | --- | --- |
| Admin | admin | Password123! |
| Kasir | kasir | Password123! |

Akun dan inventori contoh hanya di-seed pada environment `local` atau `testing`. Seeder menggunakan `firstOrCreate`, sehingga menjalankan seeder kembali tidak mereset password atau stok yang sudah diubah. Tidak ada transaksi fiktif yang di-seed.

Login menggunakan username. Pendaftaran publik melalui **Daftar sekarang** membuat akun dengan peran kasir. Admin juga dapat membuat akun melalui menu **Pengguna**. Akun sendiri tidak dapat dihapus atau diturunkan perannya melalui menu tersebut; pengguna yang memiliki transaksi tidak dapat dihapus agar riwayat tetap utuh.

## Fitur dan akses

| Halaman | Admin | Kasir |
| --- | --- | --- |
| Dashboard dan indikator stok ≤ 5 | Ya | Tidak |
| Kategori dan inventori barang | Ya | Tidak |
| POS, pencarian nama/kode, keranjang dan checkout | Ya | Ya |
| Penjualan hari ini | Semua kasir | Transaksi sendiri |
| Struk HTML dan PDF | Semua transaksi | Transaksi sendiri |
| Laporan periode, Excel dan PDF | Ya | Tidak |
| Pengguna, profil admin dan pengaturan toko | Ya | Tidak |

Inventori menggunakan pagination, pencarian, dan DataTables di server. Kategori serta barang diarsipkan dengan soft delete. Mengarsipkan kategori juga mengarsipkan barang di dalamnya dalam satu transaksi database. Data yang diarsipkan tidak dijual lagi; struk lama tetap tersedia.

Laporan menghitung pendapatan, laba, serta jumlah transaksi sesuai rentang tanggal yang inklusif. Excel berisi invoice, waktu, kasir, total, pembayaran, kembalian, dan laba per transaksi. Teks pada Excel disimpan sebagai teks untuk menghindari eksekusi formula dari nama pengguna.

## Checkout dan integritas data

Implementasi utama berada di `app/Services/CheckoutService.php`:

1. Validasi struktur keranjang, kuantitas, pembayaran, dan token UUID melalui Form Request.
2. Jalankan seluruh perubahan melalui `DB::transaction()` dengan retry deadlock.
3. Kunci akun kasir dan baris barang dengan `lockForUpdate()`. Barang dikunci berdasarkan urutan ID untuk mengurangi deadlock.
4. Hitung ulang total dari harga database dan periksa stok serta pembayaran di server.
5. Simpan header dan detail, lalu kurangi stok menggunakan `decrement()`.
6. Arahkan pengguna ke struk. Token checkout unik membuat pengiriman ulang mengembalikan transaksi yang sama tanpa mengurangi stok lagi.

Detail transaksi menambahkan snapshot **nama barang, kode barang, dan harga beli**, selain harga jual yang diwajibkan PRD. Dengan demikian, penggantian nama/harga dan pengarsipan barang tidak mengubah isi struk atau laba historis. Invoice menggunakan tanggal dan ULID agar aman digunakan beberapa kasir sekaligus. Laba mendukung nilai negatif saat barang dijual di bawah modal.

## Cetak dan pengaturan toko

Struk menyediakan pilihan lebar **58 mm** atau **80 mm**, cetak browser, dan unduh PDF 80 mm. Atur ukuran kertas pada driver printer dan matikan header/footer browser. PDF struk panjang dapat berlanjut ke halaman berikutnya. Perangkat printer fisik belum diuji.

Isi nama, alamat, telepon, serta catatan struk melalui **Pengaturan toko**. Akun hanya menggunakan username. Jika lupa kata sandi, hubungi admin untuk mengatur ulang melalui menu **Pengguna**. Kata sandi akun sendiri dapat diubah melalui **Profil akun**.

## Pengujian

```powershell
php artisan test
php tests/Support/mysql-smoke.php
npm.cmd run build
npm.cmd run test:browser
```

Pengujian PHP menggunakan database SQLite `:memory:` yang terpisah dari database toko. Cakupannya meliputi otorisasi, autentikasi, CRUD dan validasi, soft delete, snapshot struk/laba, laba negatif, pembayaran dan stok tidak cukup, rollback saat penulisan gagal, checkout berulang, filter tanggal, serta unduhan Excel/PDF.

Pemeriksaan MySQL opsional di `tests/Support/mysql-smoke.php` memverifikasi checkout, pengurangan stok, idempotensi, laba negatif, dan engine InnoDB menggunakan konfigurasi lokal. Semua fixture dan perubahan di-rollback setelah pemeriksaan; nomor auto-increment dapat tetap bertambah. Pengujian ini tidak mensimulasikan dua koneksi checkout yang berjalan bersamaan.

Pengujian Playwright menggunakan Chrome yang sudah terpasang, akun contoh, dan database lokal yang telah di-seed. Pengujian ini memeriksa login kedua peran, DataTables, pencarian AJAX, jumlah keranjang, pembayaran/kembalian, dan layout ponsel. Pengujian browser tidak menyelesaikan checkout sehingga tidak membuat transaksi atau mengubah stok. Konfigurasi browser berada di `playwright.config.js`; ubah channel jika menggunakan browser lain. Hasil dan tangkapan layar tersimpan di `test-results/` yang diabaikan Git.

## Deployment Laravel

Aplikasi ini dijalankan pada hosting PHP/MySQL dengan document root ke direktori `public/`. Isi `.env` server, gunakan `APP_ENV=production`, `APP_DEBUG=false`, HTTPS, koneksi database tersendiri. Jalankan `composer install --no-dev --optimize-autoloader`, `npm.cmd ci`, `npm.cmd run build`, `php artisan migrate --force`, dan `php artisan optimize`. Pastikan direktori `storage/` dan `bootstrap/cache/` dapat ditulis oleh proses PHP.

Seed data demo sebelum dipakai di toko hanya pada environment lokal. Untuk menyiapkan admin pertama di production, buat akun melalui Tinker pada server tepercaya dengan `App\Models\User::create(...)`, mengisi `name`, `username` unik, `role => 'admin'`, dan kata sandi yang kuat; model akan melakukan hashing otomatis. Pengguna berikutnya dibuat melalui antarmuka admin. Simpan cadangan MySQL secara berkala. Source ini belum dipublikasikan ke hosting eksternal.
