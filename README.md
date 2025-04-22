# 🎓 Prom Night Ticketing Website

Website ini dibuat untuk mempermudah proses pemesanan tiket acara **Prom Night Sekolah 2025**. Dibangun menggunakan **Laravel**, sistem ini dirancang untuk membantu panitia mengelola data pemesan, memvalidasi bukti pembayaran, dan menyediakan dashboard real-time yang praktis serta informatif.

---

## 📌 Deskripsi Project

**Prom** adalah aplikasi web interaktif yang memungkinkan siswa melakukan pemesanan tiket prom night secara efisien. Pengguna cukup mengisi data seperti NIS, nama, email, kelas, jumlah tiket, serta metode pembayaran yang diinginkan. Setelah itu, mereka dapat mengunggah bukti pembayaran langsung melalui sistem yang telah terhubung ke API imgbb.

Admin memiliki akses ke dashboard khusus untuk memantau seluruh pemesanan, memverifikasi bukti pembayaran, dan mengelola status validasi setiap pemesan dengan mudah dan cepat.

---

## 🧩 Fitur Utama

- 📝 Formulir pemesanan tiket dengan validasi input
- 📤 Upload bukti pembayaran melalui API imgbb
- 🖼️ Preview gambar bukti sebelum dikirim
- 🛠️ Panel admin untuk melihat, memfilter, dan memvalidasi pemesanan
- 🔍 Pencarian data berdasarkan NIS, nama, atau email
- 🔐 Sistem autentikasi aman menggunakan Laravel Breeze

---

## 🗃️ Struktur Data Tiket

Model `Tiket` menyimpan informasi sebagai berikut:

| Field         | Deskripsi                                               |
|---------------|----------------------------------------------------------|
| `order_id`    | ID unik tiap pemesanan                                   |
| `nis`         | Nomor Induk Siswa                                        |
| `nama`        | Nama lengkap pemesan                                     |
| `email`       | Email pemesan                                            |
| `phone`       | Nomor telepon yang bisa dihubungi                        |
| `kelas`       | Kelas pemesan                                            |
| `jumlah_tiket`| Jumlah tiket yang dipesan                                |
| `harga`       | Total harga sesuai jumlah tiket                          |
| `metodebayar` | Metode pembayaran (contoh: transfer bank)                |
| `bukti`       | URL gambar bukti pembayaran                              |
| `status`      | Status validasi (pending, success, rejected)             |
| `entry`       | Tanggal & waktu pemesanan dilakukan                      |

---

## 🛠️ Teknologi yang Digunakan

- **Laravel 12** — backend utama
- **Laravel Breeze** — autentikasi dan scaffolding
- **Tailwind CSS** — styling yang modern dan responsif
- **SweetAlert2** — tampilan alert yang menarik dan interaktif
- **imgbb API** — untuk upload bukti pembayaran
- **MySQL** — database utama
- **HTML5 QR Code Reader** *(planned)* — untuk validasi tiket saat event

---

## 🔒 Keamanan

- ✅ Validasi input pengguna dengan `Form Request`
- ✅ Perlindungan terhadap SQL Injection melalui Eloquent & Query Builder
- ✅ Validasi file dan batasan format untuk upload bukti
- ✅ Autentikasi pengguna dan proteksi halaman admin dengan middleware

---

## 🔎 Rencana Pengembangan Selanjutnya

- ✅ Integrasi scanner QR Code untuk validasi tiket di pintu masuk
- ✅ Fitur ekspor data pemesan ke format Excel
- ✅ Statistik penjualan & laporan pendapatan
- ✅ Notifikasi email setelah tiket berhasil dipesan
- ✅ Halaman landing prom untuk publikasi dan promosi acara

---

## 🤝 Kontribusi

Kontribusi sangat terbuka! Silakan fork proyek ini dan ajukan pull request jika kamu punya ide fitur, perbaikan, atau peningkatan antarmuka.

---

Made with ❤️ by [Raaki30](https://github.com/Raaki30)  
Prom Night bukan sekadar pesta — tapi momen sekali seumur hidup. ✨

