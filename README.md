# 📦 Panduan Instalasi Proyek Laravel 12

---

## 📌 Persyaratan Sistem

Pastikan perangkat Anda telah terinstal:

* **PHP ≥ 8.2**
* **Composer**
* **MySQL / MariaDB**
* **Git**
* **Visual Studio Code** (atau text editor lain)

---

## 🚀 Langkah Instalasi

### 1️⃣ Clone Repository dari GitHub

Buka **Terminal / Command Prompt / Git Bash**, lalu jalankan:

```bash
git clone https://github.com/username/nama-repository.git
```

Masuk ke folder project:

```bash
cd nama-repository
```

Kemudian buka project menggunakan **Visual Studio Code**:

```bash
code .
```

---

### 2️⃣ Install Dependency Laravel

📍 **Perintah diketik di Terminal Visual Studio Code**

Di Visual Studio Code:

* Klik menu **Terminal → New Terminal**
* Pastikan lokasi terminal berada di folder project

Kemudian jalankan perintah berikut:

```bash
composer install
```

Tunggu hingga proses selesai.

---

### 3️⃣ Membuat File Environment (.env)

#### Langkah-langkah:

1. Buka folder project menggunakan **Visual Studio Code**
2. Cari file bernama:

   ```
   .env.example
   ```
3. **Copy** file tersebut
4. **Paste** di folder yang sama
5. Rename hasil copy menjadi:

   ```
   .env
   ```

📌 Pastikan:

* Nama file benar-benar **`.env`**
* Bukan **`.env.txt`**

---

### 4️⃣ Konfigurasi File `.env`

Buka file `.env`, lalu sesuaikan konfigurasi database:

```env
APP_NAME=Laravel
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

📌 Pastikan database sudah dibuat terlebih dahulu melalui **phpMyAdmin** atau **MySQL Client**.

---

### 5️⃣ Generate Application Key

📍 **Perintah diketik di Terminal Visual Studio Code**

```bash
php artisan key:generate
```

Jika berhasil, nilai `APP_KEY` akan otomatis terisi di file `.env`.

---

### 6️⃣ Migrasi Database

📍 **Perintah diketik di Terminal Visual Studio Code**

Jalankan migrasi database:

```bash
php artisan migrate
```

---

### 7️⃣ Menjalankan Aplikasi Laravel

📍 **Perintah diketik di Terminal Visual Studio Code**

```bash
php artisan serve
```

Akses aplikasi melalui browser:

```
http://localhost:8000
```

---

## 🧩 Struktur Folder Penting

```
app/
├── Http/
│   ├── Controllers/
│   ├── Requests/
│
resources/
├── views/
│
public/
├── adminlte/
```

---