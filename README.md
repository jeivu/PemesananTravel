{ Pastikan sistem Anda memenuhi persyaratan berikut: }

PHP (Disarankan versi >= 8.2)

Composer

Node.js & NPM/Yarn (Untuk mengkompilasi aset frontend Vite)

MySQL (Sistem database yang digunakan)

{ Cara Setup dan Menjalankan Aplikasi }
1. Kloning Repositori & Instalasi PHP

git clone [URL_REPOSITORI_ANDA] PemesananTravel
cd PemesananTravel
composer install

2. Konfigurasi Lingkungan (.env)

cp .env.example .env
php artisan key:generate

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pemesanan_travel
DB_USERNAME=root
DB_PASSWORD=

3. Migrasi Database dan Data Awal

php artisan migrate:fresh --seed

4. Instalasi dan Kompilasi Frontend

npm install
npm run dev

5. Menjalankan Server Laravel

php artisan serve

{ Akun Login Pengujian }

Admin | admin@travel.com | password
Penumpang | penumpang@travel.com | password