# Database Setup Guide - CoolE-Bill POS

## 📋 Daftar Tabel Database

### 1. **users**
Tabel untuk menyimpan data pengguna (admin & kasir)
- id
- name
- username (unique)
- password
- role (enum: admin/kasir)
- remember_token
- timestamps

### 2. **kategoris**
Tabel untuk kategori produk
- id
- nama_kategori
- deskripsi
- status (enum: aktif/nonaktif)
- timestamps

### 3. **produks**
Tabel untuk produk
- id
- kode_produk (unique)
- nama_produk
- kategori_id (foreign key -> kategoris)
- harga (decimal)
- stok (integer)
- deskripsi
- gambar
- status (enum: aktif/nonaktif)
- timestamps

### 4. **transaksis**
Tabel untuk transaksi penjualan
- id
- kode_transaksi (unique)
- user_id (foreign key -> users)
- subtotal (decimal)
- pajak (decimal)
- total (decimal)
- metode_pembayaran (enum: tunai/transfer/e-wallet/kartu)
- status (enum: sukses/pending/batal)
- timestamps

### 5. **transaksi_details**
Tabel detail item transaksi
- id
- transaksi_id (foreign key -> transaksis)
- produk_id (foreign key -> produks)
- jumlah (integer)
- harga (decimal)
- subtotal (decimal)
- timestamps

---

## 🚀 Cara Menjalankan Migration & Seeder

### Step 1: Refresh Database (Hapus semua data & tabel)
```bash
php artisan migrate:fresh
```

### Step 2: Jalankan Seeder (Isi data dummy)
```bash
php artisan db:seed
```

### Atau Sekaligus (Fresh + Seed)
```bash
php artisan migrate:fresh --seed
```

---

## 📊 Data Dummy yang Akan Di-seed

### Users (UserSeeder)
- Admin User (username: admin, password: admin123, role: admin)
- Kasir User (username: kasir, password: kasir123, role: kasir)

### Kategori (KategoriSeeder)
1. Makanan - Aktif (45 produk)
2. Minuman - Aktif (35 produk)
3. Snack - Aktif (25 produk)
4. Dessert - Aktif (15 produk)
5. Lain-lain - Nonaktif (0 produk)

### Produk (ProdukSeeder) - 12 Produk
**Makanan:**
- PRD001: Nasi Goreng (Rp15.000, stok: 50)
- PRD002: Mie Ayam (Rp12.000, stok: 30)
- PRD003: Nasi Uduk (Rp10.000, stok: 40)

**Minuman:**
- PRD004: Es Teh Manis (Rp5.000, stok: 100)
- PRD005: Kopi Hitam (Rp8.000, stok: 80)
- PRD006: Jus Jeruk (Rp12.000, stok: 60)

**Snack:**
- PRD007: Pisang Goreng (Rp8.000, stok: 35)
- PRD008: Kentang Goreng (Rp10.000, stok: 40)
- PRD009: Popcorn (Rp10.000, stok: 40)

**Dessert:**
- PRD010: Cake Coklat (Rp25.000, stok: 15)
- PRD011: Puding (Rp8.000, stok: 25)
- PRD012: Es Krim (Rp15.000, stok: 30)

### Transaksi (TransaksiSeeder) - 10 Transaksi
- TRX001: Total Rp27.500 (Tunai, Sukses)
- TRX002: Total Rp137.500 (Transfer, Sukses)
- TRX003: Total Rp33.000 (Tunai, Pending)
- TRX004-010: Random transaksi dengan berbagai metode pembayaran

---

## 🔗 Relasi Antar Tabel

```
users (1) ----< transaksis (many)
kategoris (1) ----< produks (many)
transaksis (1) ----< transaksi_details (many)
produks (1) ----< transaksi_details (many)
```

---

## ⚙️ Model & Relationships

### User Model
- hasMany: transaksis

### Kategori Model
- hasMany: produks

### Produk Model
- belongsTo: kategori
- hasMany: transaksiDetails

### Transaksi Model
- belongsTo: user
- hasMany: transaksiDetails

### TransaksiDetail Model
- belongsTo: transaksi
- belongsTo: produk

---

## 📝 Catatan Penting

1. **Foreign Key Constraints**: Semua foreign key menggunakan `onDelete('cascade')` sehingga jika parent dihapus, child juga terhapus otomatis.

2. **Enum Values**:
   - Role: 'admin', 'kasir'
   - Status Produk/Kategori: 'aktif', 'nonaktif'
   - Status Transaksi: 'sukses', 'pending', 'batal'
   - Metode Pembayaran: 'tunai', 'transfer', 'e-wallet', 'kartu'

3. **Decimal Precision**: 
   - Harga: 10 digit, 2 desimal
   - Total/Subtotal: 12 digit, 2 desimal

4. **Unique Constraints**:
   - users.username
   - produks.kode_produk
   - transaksis.kode_transaksi

---

## 🔍 Testing Database

### Cek koneksi database:
```bash
php artisan db:show
```

### Cek tabel yang sudah dibuat:
```bash
php artisan db:table users
php artisan db:table kategoris
php artisan db:table produks
php artisan db:table transaksis
php artisan db:table transaksi_details
```

### Rollback migration (jika ada error):
```bash
php artisan migrate:rollback
```

### Fresh migration tanpa seeder:
```bash
php artisan migrate:fresh
```

---

## ✅ Checklist Setup Database

- [ ] Konfigurasi `.env` (DB_DATABASE, DB_USERNAME, DB_PASSWORD)
- [ ] Jalankan `php artisan migrate:fresh --seed`
- [ ] Login dengan username: admin, password: admin123
- [ ] Cek Dashboard untuk melihat stats
- [ ] Cek semua menu (Produk, Kategori, Transaksi, Laporan, Kelola User)

---

**Selamat! Database Anda siap digunakan! 🎉**
