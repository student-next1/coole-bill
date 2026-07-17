# 🗄️ Database CoolE-Bill POS

## 📦 Quick Setup

### Windows:
Double-click file `SETUP_COMMANDS.bat` atau jalankan:
```bash
php artisan migrate:fresh --seed
```

### Manual:
```bash
# Step 1: Migrasi database
php artisan migrate:fresh

# Step 2: Seed data
php artisan db:seed
```

---

## 🔑 Login Credentials (Seeder)

| Username | Password | Role |
|----------|----------|------|
| admin    | admin123 | Admin |
| kasir    | kasir123 | Kasir |

---

## 📊 Database Structure

```
┌─────────────────┐
│     USERS       │ (Admin & Kasir)
└────────┬────────┘
         │ 1
         │
         │ many
┌────────▼────────┐
│   TRANSAKSIS    │ (Header Transaksi)
└────────┬────────┘
         │ 1
         │
         │ many
┌────────▼──────────────┐
│  TRANSAKSI_DETAILS    │ (Item Transaksi)
└───────────────────────┘
         │ many
         │
         │ 1
┌────────▼────────┐
│    PRODUKS      │ (Produk)
└────────┬────────┘
         │ many
         │
         │ 1
┌────────▼────────┐
│   KATEGORIS     │ (Kategori)
└─────────────────┘
```

---

## 📝 Tables Overview

### 1. **users**
```sql
- id (PK)
- name
- username (unique)
- password
- role (admin/kasir)
- timestamps
```

### 2. **kategoris**
```sql
- id (PK)
- nama_kategori
- deskripsi
- status (aktif/nonaktif)
- timestamps
```

### 3. **produks**
```sql
- id (PK)
- kode_produk (unique)
- nama_produk
- kategori_id (FK)
- harga (decimal)
- stok (int)
- deskripsi
- gambar
- status (aktif/nonaktif)
- timestamps
```

### 4. **transaksis**
```sql
- id (PK)
- kode_transaksi (unique)
- user_id (FK)
- subtotal (decimal)
- pajak (decimal)
- total (decimal)
- metode_pembayaran (tunai/transfer/e-wallet/kartu)
- status (sukses/pending/batal)
- timestamps
```

### 5. **transaksi_details**
```sql
- id (PK)
- transaksi_id (FK)
- produk_id (FK)
- jumlah (int)
- harga (decimal)
- subtotal (decimal)
- timestamps
```

---

## 🎲 Dummy Data

### Kategori (5)
- Makanan ✅
- Minuman ✅
- Snack ✅
- Dessert ✅
- Lain-lain ❌

### Produk (12)
| Kode | Nama | Kategori | Harga | Stok |
|------|------|----------|-------|------|
| PRD001 | Nasi Goreng | Makanan | 15.000 | 50 |
| PRD002 | Mie Ayam | Makanan | 12.000 | 30 |
| PRD003 | Nasi Uduk | Makanan | 10.000 | 40 |
| PRD004 | Es Teh Manis | Minuman | 5.000 | 100 |
| PRD005 | Kopi Hitam | Minuman | 8.000 | 80 |
| PRD006 | Jus Jeruk | Minuman | 12.000 | 60 |
| PRD007 | Pisang Goreng | Snack | 8.000 | 35 |
| PRD008 | Kentang Goreng | Snack | 10.000 | 40 |
| PRD009 | Popcorn | Snack | 10.000 | 40 |
| PRD010 | Cake Coklat | Dessert | 25.000 | 15 |
| PRD011 | Puding | Dessert | 8.000 | 25 |
| PRD012 | Es Krim | Dessert | 15.000 | 30 |

### Transaksi (10)
- TRX001-TRX010 dengan berbagai metode pembayaran
- Status: Sukses (9), Pending (1)
- Total nilai: ~Rp500.000

---

## 🔧 Useful Commands

```bash
# Rollback migration
php artisan migrate:rollback

# Reset database
php artisan migrate:fresh

# Seed saja (tanpa reset)
php artisan db:seed

# Fresh + Seed sekaligus
php artisan migrate:fresh --seed

# Lihat info database
php artisan db:show

# Lihat struktur tabel
php artisan db:table users
php artisan db:table produks
```

---

## 📁 File Locations

### Migrations
```
database/migrations/
├── 0001_01_01_000000_create_users_table.php
├── 2024_01_01_000001_create_kategoris_table.php
├── 2024_01_01_000002_create_produks_table.php
├── 2024_01_01_000003_create_transaksis_table.php
└── 2024_01_01_000004_create_transaksi_details_table.php
```

### Seeders
```
database/seeders/
├── DatabaseSeeder.php
├── UserSeeder.php
├── KategoriSeeder.php
├── ProdukSeeder.php
└── TransaksiSeeder.php
```

### Models
```
app/Models/
├── User.php
├── Kategori.php
├── Produk.php
├── Transaksi.php
└── TransaksiDetail.php
```

---

## ⚠️ Important Notes

1. **Cascade Delete**: Jika parent dihapus, child otomatis terhapus
2. **Timestamps**: Semua tabel memiliki created_at & updated_at
3. **Soft Delete**: Belum diimplementasi (data benar-benar terhapus)
4. **Validation**: Validasi dilakukan di level Controller

---

## 🐛 Troubleshooting

### Error: "Access denied for user"
```bash
# Cek konfigurasi .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=coole_bill
DB_USERNAME=root
DB_PASSWORD=
```

### Error: "SQLSTATE[42S01]: Base table"
```bash
# Jalankan fresh migration
php artisan migrate:fresh --seed
```

### Error: "Class 'App\Models\Kategori' not found"
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
composer dump-autoload
```

---

**Happy Coding! 🚀**
