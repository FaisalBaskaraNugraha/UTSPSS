# Aplikasi Inventaris Sederhana

Aplikasi ini terdiri dari backend API yang dibangun dengan Laravel dan sebuah frontend yang dibangun dengan Vue.js, yang saling berinteraksi untuk mengelola data inventaris.

## Alur Pengerjaan Singkat

Berikut adalah tahapan utama dalam pengembangan proyek ini:

### 1. Pengembangan Backend (Laravel API)

* **Setup Awal:** Menggunakan Docker dan Docker Compose untuk menyiapkan lingkungan pengembangan yang terdiri dari container aplikasi PHP (Laravel), web server Nginx, dan database PostgreSQL.
* **Desain Database:** Membuat file migrasi untuk mendefinisikan struktur tabel database (`uts3admins`, `uts3categories`, `uts3suppliers`, `uts3items`) beserta relasinya.
* **Model Eloquent:** Mendefinisikan model Eloquent (`Uts3admin`, `Uts3category`, `Uts3supplier`, `Uts3item`) untuk berinteraksi dengan tabel database terkait.
* **Controller API:** Membuat controller API (`Uts3ItemController`, `Uts3CategoryController`, `Uts3SupplierController`, `Uts3ReportController`) untuk menangani logika bisnis dan berinteraksi dengan model.
* **Definisi Rute API:** Menentukan rute API (`routes/api.php`) untuk endpoint-endpoint seperti menampilkan daftar item, menambah item baru, melihat detail, dll., serta rute untuk kategori, supplier, dan laporan.
* **Konfigurasi CORS:** Mengkonfigurasi CORS (Cross-Origin Resource Sharing) di backend agar API dapat diakses oleh aplikasi frontend yang berjalan di domain atau port yang berbeda selama development.

### 2. Pengembangan Frontend (Vue.js)

* **Inisialisasi Proyek:** Menggunakan Vite untuk membuat proyek Vue.js 3 baru dengan cepat.
* **Instalasi Dependensi:** Menambahkan library seperti Axios untuk request HTTP ke API, Vue Router untuk navigasi antar halaman, dan dependensi untuk styling (seperti CSS biasa jika tidak menggunakan framework CSS).
* **Konfigurasi Axios:** Membuat instance Axios terpusat (`services/api.js`) dengan baseURL API backend untuk memudahkan pemanggilan API.
* **Konfigurasi Vue Router:** Mendefinisikan rute frontend (`router/index.js`) yang akan memetakan URL ke komponen View yang berbeda.
* **Struktur Komponen:** Mengatur struktur direktori untuk komponen reusable (`components/`) dan komponen halaman (`views/`).
* **Pengembangan View:** Membuat komponen View (`.vue` files) untuk setiap halaman (misalnya daftar item, tambah item, ringkasan stok, dll.). Setiap View berinteraksi dengan API backend melalui Axios untuk mengambil atau mengirim data dan menggunakan Vue Router untuk navigasi.
* **Styling:** Menerapkan styling menggunakan CSS biasa (melalui file global atau `<style scoped>` di komponen).

### 3. Integrasi dan Pengujian

* Memastikan backend API berjalan dan dapat diakses oleh frontend.
* Memastikan konfigurasi CORS sudah benar.
* Mengembangkan dan menguji setiap fungsionalitas di frontend untuk memastikan interaksi dengan API berjalan sesuai harapan.



 
