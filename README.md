## ⚡ Instalasi Super Cepat
### 🔥 Persyaratan
- **PHP > 8.3.0**
- **MySQL**

### 🚀 Setup dengan Makefile (Paling Gampang)
1. Clone repository ini, lalu jalankan:
   ```sh
   make setup
   ```
2. Buat database baru di MySQL dan sesuaikan `.env`
3. Jalankan setup database:
   ```sh
   make setup-db
   ```
4. (Opsional) Tambahkan data dummy:
   ```sh
   make setup-dummy
   ```
5. Jalankan aplikasi:
   ```sh
   make run
   ```

### 🛠️ Setup Manual (Kalau Mau Cara Lama)
1. Clone repository ini, lalu jalankan:
   ```sh
   composer install
   ```
2. Salin konfigurasi default:
   ```sh
   cp .env.example .env
   ```
3. Sesuaikan `.env` dengan database Anda.
4. Generate application key:
   ```sh
   php artisan key:generate
   ```
5. Buat symbolic link untuk storage:
   ```sh
   php artisan storage:link
   ```
6. Jalankan migrasi database:
   ```sh
   php artisan migrate
   ```
7. Tambahkan akun administrator:
   ```sh
   php artisan db:seed --class=UserSeeder
   ```
8. Tambahkan konfigurasi awal:
   ```sh
   php artisan db:seed --class=ConfigSeeder
   ```
9. (Opsional) Tambahkan data dummy:
   ```sh
   php artisan db:seed
   ```
10. Jalankan aplikasi:
   ```sh
   php artisan serve
