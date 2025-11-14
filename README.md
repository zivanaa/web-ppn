# PT Pramudita Pupuk Nusantara (PTPPN) Website

[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3.3-7952B3?style=flat&logo=bootstrap)](https://getbootstrap.com/)
[![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?style=flat&logo=php)](https://php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat&logo=mysql)](https://mysql.com/)
[![Chart.js](https://img.shields.io/badge/Chart.js-4.4.0-FF6384?style=flat&logo=chart.js)](https://chartjs.org/)

PT Pramudita Pupuk Nusantara adalah perusahaan pupuk nasional yang inovatif dan berkelanjutan, berkomitmen untuk mendukung pertanian dan peternakan berkelanjutan melalui produk berkualitas tinggi, peningkatan produktivitas pertanian, kesejahteraan petani, dan menjadi solusi pertanian masa depan.

## 🌟 Fitur Utama

### 🏠 Halaman Publik
- **Beranda**: Hero carousel, kalkulator tani, hasil pupuk, galeri, dan testimoni
- **Produk**: Katalog produk dengan detail lengkap (manfaat, keunggulan, aturan pakai)
- **Galeri**: Galeri foto kegiatan perusahaan dengan modal popup
- **FAQ**: Pertanyaan umum tentang produk pupuk silika
- **Shop**: Link ke platform e-commerce (TikTok Shop, Lazada, Shopee, Tokopedia)
- **Tentang Kami**: Profil perusahaan, video, statistik, dan nilai-nilai
- **Visi & Misi**: Visi perusahaan, misi, dan prinsip-prinsip utama

### 🔐 Panel Admin
- **Manajemen Produk**: CRUD lengkap untuk produk pupuk
- **Logbook**: Pencatatan penjualan dengan analitik dan grafik
- **Testimoni**: Kelola ulasan pelanggan
- **Galeri**: Upload dan kelola foto kegiatan
- **FAQ**: Kelola pertanyaan dan jawaban

## 🛠️ Teknologi yang Digunakan

### Backend
- **PHP 8.0+**: Server-side scripting
- **MySQL 8.0+**: Database management

### Frontend
- **Bootstrap 5.3.3**: CSS framework
- **Chart.js 4.4.0**: Data visualization
- **Font Awesome 5.15.3**: Icon library
- **Bootstrap Icons 1.11.3**: Additional icons

### Tools & Libraries
- **jQuery**: DOM manipulation
- **Bootstrap JavaScript**: Interactive components
- **Custom CSS/JS**: Styling dan interaktivitas khusus

## 📋 Persyaratan Sistem

- **Web Server**: Apache/Nginx dengan PHP support
- **PHP**: Versi 8.0 atau lebih tinggi
- **Database**: MySQL 8.0 atau MariaDB 10.5+
- **Browser**: Modern browsers (Chrome, Firefox, Safari, Edge)

## 🚀 Instalasi

### 1. Clone Repository
```bash
git clone https://github.com/FauzanRAY-STAR/Web_PPN.git
```
- Patikan melakukan clone pada root `xampp/htdocs`
  
### 2. Setup Web Server
- Pastikan XAMPP/WAMP atau server lokal lainnya terinstall
- Copy folder project ke `htdocs` (untuk XAMPP)
- Akses via `http://localhost/WEB_PPN/`

### 3. Konfigurasi Database
```sql

CREATE DATABASE db_ppn;


```

### 4. Konfigurasi Koneksi Database
Edit file `config/koneksi.php`:
```php
<?php
$host = 'localhost';
$username = 'root';  
$password = '';      
$database = 'db_ppn';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
```

### 5. Konfigurasi Base URL
Edit file `config/config.php`:
```php
<?php
$base_url = '/WEB_PPN/'; 
?>
```

## 📖 Penggunaan

### Akses Website
- **Halaman Publik**: `http://localhost/WEB_PPN/`
- **Admin Panel**: Login melalui modal di navbar
  - Username: `admin`
  - Password: `admin`

### Navigasi Admin Panel
1. Login dengan kredensial admin
2. Gunakan sidebar untuk navigasi antar menu:
   - Manajemen Produk
   - Logbook
   - Testimoni
   - Galeri
   - FAQ

## 📁 Struktur File

```
WEB_PPN/
├── index.php                 # Entry point
├── login.php                 # Admin login handler
├── logout.php                # Admin logout handler
├── page.php                  # Page router
├── README.md                 # Dokumentasi project
├──
├── admin/                    # Admin panel
│   ├── auth_check.php        # Authentication check
│   ├── index.php            # Admin redirect
│   ├── page/                # Admin pages
│   │   ├── produk.php       # Product management
│   │   ├── logbook.php      # Sales logbook
│   │   ├── ulasan.php       # Testimonials
│   │   ├── galeri.php       # Gallery management
│   │   └── faq.php          # FAQ management
│   └── template/            # Admin templates
│       ├── navbar.php       # Navigation bar
│       ├── sidebar.php      # Admin sidebar
│       ├── footer.php       # Footer
│       └── whatsapp_float.php # WhatsApp button
│
├── page/                     # Public pages
│   ├── beranda.php          # Home page
│   ├── halaman_produk.php   # Product catalog
│   ├── detail_produk.php    # Product details
│   ├── galeri.php           # Gallery
│   ├── faq.php              # FAQ
│   ├── shop.php             # E-commerce links
│   ├── tentang_kami.php     # About us
│   └── visi_misi.php        # Vision & mission
│
├── config/                   # Configuration
│   ├── config.php           # Base URL config
│   ├── koneksi.php          # Database connection
│   └── ambil_menu.php       # Menu data
│
├── asset/                    # Static assets
│   ├── img/                 # Images
│   ├── js/                  # JavaScript files
│   ├── style/               # CSS files
│   └── style/bootstrap-5.3.3-dist/ # Bootstrap
│
└── .htaccess                # URL rewriting rules
```

## 🎨 Fitur Khusus

### Kalkulator Tani
- Hitung kebutuhan pupuk berdasarkan jenis tanaman dan luas lahan
- Popup hasil perhitungan dengan opsi pesan

### Responsive Design
- Mobile-first approach
- Bootstrap grid system
- Custom breakpoints untuk optimalisasi

### Admin Analytics
- Chart penjualan produk (Chart.js)
- Statistik pendapatan bulanan/total
- Filter dan pencarian data

## 🔧 Pengembangan

### Menambah Produk Baru
1. Upload gambar ke `asset/img/`
2. Tambahkan data produk di array `$produk` di `halaman_produk.php`
3. Buat halaman detail di `detail_produk.php`

### Menambah Halaman Admin
1. Buat file di `admin/page/`
2. Tambahkan menu di `admin/template/sidebar.php`
3. Implementasikan fungsi CRUD

### Styling
- Gunakan `asset/style/` untuk CSS kustom
- Override Bootstrap classes jika diperlukan
- Maintain konsistensi warna brand (#2B8D4C, #D5D44B)

## 🤝 Kontribusi

1. Fork repository
2. Buat branch fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request



