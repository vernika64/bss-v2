# APLIKASI SIMULASI MINI BANK SYARIAH V1.0

(Masih dalam tahap alpha)

<!-- `
Pesan Tidak Rahasia Wkwk

` -->

Aplikasi untuk melakukan simulasi operasional mini bank syariah. Dapat digunakan untuk jaringan lokal maupun online.

## Fitur Utama Aplikasi

1. Dapat membuat cabang bank lebih dari satu

2. Multi User yang terikat dengan cabang bank

3. Akuntansi Untuk Bank Syariah (Masih dalam pengembangan)

4. Tabungan menggunakan akad Wadiah

5. Pembiayaan Tangguh menggunakan akad Murabahah

## Library dan Framework yang digunakan di dalam aplikasi

1. `Laravel 8`

2. `Vue 3`

3. `Vue Router 4`

4. `Tailwind CSS 3`

 ## Cara Install Aplikasi

 ### Software untuk memakai Aplikasi
 1. `PHP 7.4`
 2. `MySQL` atau `MariaDB`
 3. Disarankan menggunakan browser turunan Chrome / Chromium

 ### Software untuk menginstall Aplikasi
 1. `Composer`
 2. `NodeJS`

### Prosedur Instalasi

Sebelum menginstall aplikasi dianjurkan untuk membuat database terlebih dahulu. Berikut tahap instalasi aplikasi:

1. clone project menggunakan git
2. install dependency dan library yang dibutuhkan di dalam project menggunakan composer dengan command `composer install` dan npm menggunakan command `npm install`
3. copy paste file `.env.example` dan rubah file yang dipaste dengan nama `.env`
4. rubah pengatuan autentikasi database dan nama database di dalam `.env`
5. generate `key` untuk `laravel` menggunakan command `php artisan key:generate`
6. selesai

## Cara Pakai Aplikasi

Aplikasi ini terbagi menjadi dua bagian. Server API menggunakan Laravel dan Frontend Website menggunakan Vue.Js. Untuk memulai aplikasi dapat menggunakan aplikasi `terminal` dengan dua command:

Untuk Start Server API
`php artisan serve`

Untuk Start Frontend
`npm run hot`

Akses Halaman Website dengan URL yang telah disediakan oleh command pada `npm`

## Log Update

TBW