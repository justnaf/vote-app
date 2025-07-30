<p align="center"><a href="#" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# E-Vote - Sistem E-Voting Fleksibel

## About The Project

**E-Vote** adalah aplikasi e-voting berbasis web yang dibangun dengan framework Laravel. Sistem ini dirancang agar fleksibel, memungkinkan administrator untuk membuat dan mengelola berbagai jenis kegiatan voting dengan mudah. Setiap kegiatan dapat dikonfigurasi untuk pemilihan langsung (satu suara per orang) atau pemilihan gaya formatur (beberapa suara per orang).

Fitur utama dari aplikasi ini meliputi:

-   **Manajemen Kegiatan Dinamis**: Administrator dapat membuat, mengedit, dan menghapus kegiatan voting kapan saja.
-   **Tipe Vote Fleksibel**: Mendukung pemilihan **langsung** (satu pilihan) dan **formatur** (beberapa pilihan).
-   **Manajemen Kandidat**: Kemudahan untuk menambah dan menghapus kandidat untuk setiap kegiatan, lengkap dengan foto dan informasi lainnya.
-   **Generate Pemilih Massal**: Fitur untuk membuat ratusan akun pemilih secara otomatis untuk kegiatan tertentu.
-   **Ekspor Kredensial**: Ekspor data username dan password pemilih ke dalam format Excel (.xlsx) untuk distribusi.
-   **Dashboard Terpisah**: Antarmuka yang berbeda untuk **Admin** (panel kontrol) dan **Pemilih** (halaman voting).
-   **Hasil Voting Real-time**: Halaman khusus untuk admin melihat rekapitulasi perolehan suara secara langsung.

---

## Getting Started

Follow these steps to set up the project on your local machine for development and testing purposes.

### Prerequisites

-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   Database (e.g., MySQL, MariaDB)

### Installation

1.  **Clone the repository:**

    ```sh
    git clone [https://github.com/your-username/evote-project.git](https://github.com/your-username/evote-project.git)
    cd evote-project
    ```

2.  **Install PHP dependencies:**

    ```sh
    composer install
    ```

3.  **Install JavaScript dependencies:**

    ```sh
    npm install && npm run build
    ```

4.  **Setup your environment file:**

    ```sh
    cp .env.example .env
    ```

    Then, open the `.env` file and configure your database connection details (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

5.  **Generate an application key:**

    ```sh
    php artisan key:generate
    ```

6.  **Run the database migrations and seeders:**
    This will create all the necessary tables and populate the database with a default admin user.

    ```sh
    php artisan migrate:fresh --seed
    ```

7.  **Create a symbolic link for storage:**
    This is necessary to make uploaded candidate photos publicly accessible.
    ```sh
    php artisan storage:link
    ```

---

## Usage

After installation, you can run the local development server:

```sh
php artisan serve
```

You can now access the application in your browser.

-   **Admin Login:**
    -   URL: `http://127.0.0.1:8000/login`
    -   Username: `admin`
    -   Password: `password`

Once logged in as an admin, you will be redirected to the control panel where you can start managing voting events, candidates, and voters.

---

### AI-Assisted Development Note

Perlu diketahui bahwa sebagian besar basis kode proyek ini, termasuk struktur, logika, dan dokumentasinya, dikembangkan dengan bantuan mitra pemrograman AI. AI dimanfaatkan untuk mempercepat pengembangan, menghasilkan kode boilerplate, dan memberikan solusi untuk fungsionalitas tertentu.
