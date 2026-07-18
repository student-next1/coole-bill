# Penjelasan Flow Pembayaran dan Letak search-card.blade.php

## 📍 Halaman Utama - transaksi/create.blade.php

Ini adalah halaman pertama yang ditampilkan saat user memulai transaksi baru.

**Tampilan:**
```
┌─────────────────────────────────────────────────────────┐
│                                                           │
│  TRANSAKSI BARU                                          │
│                                                           │
│  ┌─────────────────────────┬──────────────────────────┐ │
│  │                         │                          │ │
│  │  PILIH PRODUK          │      KERANJANG           │ │
│  │  ═══════════════        │      ══════════          │ │
│  │                         │                          │ │
│  │  [Cari produk...]       │  [Item 1]  Rp50.000    │ │
│  │                         │  [Item 2]  Rp75.000    │ │
│  │  [Produk 1] [Prod 2]    │                          │ │
│  │  [Produk 3] [Prod 4]    │  ─────────────────────  │ │
│  │  [Produk 5] [Prod 6]    │  Subtotal: Rp125.000   │ │
│  │                         │  Total:    Rp125.000   │ │
│  │                         │                          │ │
│  │                         │  [💵 Tunai][🆔 Kartu ID]│ │
│  │                         │                          │ │
│  │                         │  [Proses Pembayaran]   │ │
│  │                         │  [Reset]               │ │
│  │                         │                          │ │
│  └─────────────────────────┴──────────────────────────┘ │
│                                                           │
└─────────────────────────────────────────────────────────┘
```

### Langkah-langkah:

1. **Pilih Produk**: User klik produk yang ingin dibeli
   - Produk ditambahkan ke keranjang (kanan)
   - Subtotal dan Total terupdate

2. **Pilih Metode Pembayaran**: User klik salah satu tombol:
   - 💵 **Tunai** → Langsung ke Invoice Page
   - 🆔 **Kartu ID** → Redirect ke Search Card Page

---

## 🔍 Search Card Page - search-card.blade.php

**INI HALAMAN YANG MUNCUL KETIKA USER PILIH KARTU ID**

### Kapan tampil?
Setelah user di halaman `transaksi/create` pilih produk, lalu klik tombol **"🆔 Kartu ID"**

### Flow URL:
```
1. User di: http://localhost/transaksi/create
   ↓
2. Klik "🆔 Kartu ID" 
   ↓
3. JavaScript function: selectPaymentMethod('kartu_id')
   ↓
4. POST request ke: /transaksi/select-payment
   ↓
5. Server redirect ke: /transaksi/search-card
   ↓
6. TAMPIL: search-card.blade.php
```

### Tampilan halaman:

```
┌─────────────────────────────────────────────────────────┐
│                                                           │
│  🆔 PILIH KARTU PEMBAYARAN                              │
│  ─────────────────────────────────────────────────────  │
│  Cari dan pilih kartu yang ingin digunakan              │
│                                                           │
│  ┌─────────────────────────────────────────────────┐   │
│  │  Cari Kartu                                     │   │
│  │  [        Ketik username atau ID...    ][Cari] │   │
│  │  💡 Tekan Enter atau klik tombol Cari         │   │
│  └─────────────────────────────────────────────────┘   │
│                                                           │
│  ┌─────────────────────────────────────────────────┐   │
│  │  👤 Nama Pemilik: Andi Wijaya                   │   │
│  │  📧 Username: card_001                          │   │
│  │  💰 Saldo: Rp1,000,000                          │   │
│  │                                                   │   │
│  │  ┌─────────────────────────────────────────┐   │   │
│  │  │ CARD ID: CARD-202607171328-54231       │   │   │
│  │  └─────────────────────────────────────────┘   │   │
│  │                                                   │   │
│  │  🔐 Barcode: 202607...54231                     │   │
│  │  ✓ Status: 🟢 Aktif                            │   │
│  │                                                   │   │
│  │  [✓ Gunakan Kartu Ini]                         │   │
│  └─────────────────────────────────────────────────┘   │
│                                                           │
│  [↩️ Kembali]                                            │
│                                                           │
└─────────────────────────────────────────────────────────┘
```

### Langkah-langkah di halaman ini:

1. **Search Kartu**: 
   - User ketik username (contoh: `card_001`) atau ID kartu
   - Klik tombol "Cari" atau tekan Enter
   - AJAX request ke `/transaksi/find-card?search=card_001`
   - Server return daftar kartu yang cocok

2. **Pilih Kartu**:
   - User klik tombol "✓ Gunakan Kartu Ini"
   - POST request ke `/transaksi/select-card` dengan `card_id`
   - Server store `payment_card_id` ke session
   - Server redirect ke `/transaksi/invoice`

---

## 📝 Invoice Page - invoice.blade.php

**HALAMAN BERIKUTNYA SETELAH PILIH KARTU**

### Flow URL:
```
1. Di search-card.blade.php, klik "✓ Gunakan Kartu Ini"
   ↓
2. POST ke /transaksi/select-card dengan card_id
   ↓
3. Server redirect ke: /transaksi/invoice?method=kartu_id
   ↓
4. TAMPIL: invoice.blade.php (halaman struk editable)
```

### Tampilan halaman:

```
┌─────────────────────────────────────────────────────────┐
│                                                           │
│  🧾 STRUK PEMBAYARAN                                     │
│  ═══════════════════════════════════════════════════════│
│                                                           │
│  Daftar Produk                                           │
│  ─────────────────────────────────────────────────────  │
│                                                           │
│  [Nasi Goreng]  [Qty: 5] [Harga: 50000] [Sub: 250000]  │
│  [Mie Kuah]     [Qty: 2] [Harga: 35000] [Sub: 70000]   │
│                                                           │
│  Subtotal: Rp320,000                                     │
│  Total:    Rp320,000                                     │
│                                                           │
│  [✓ Konfirmasi Pembayaran]                              │
│  [↩️ Kembali]                                            │
│                                                           │
└─────────────────────────────────────────────────────────┘
```

### User bisa:
- Edit qty, harga, nama produk
- Lihat subtotal update real-time
- Klik "✓ Konfirmasi Pembayaran"

---

## ✅ Confirmation Page - confirmation.blade.php

**HALAMAN SETELAH CONFIRM PEMBAYARAN**

### Flow URL:
```
1. Di invoice.blade.php, klik "✓ Konfirmasi Pembayaran"
   ↓
2. POST ke /transaksi/confirm dengan items, metode, dll
   ↓
3. Server:
   - Create Transaksi record
   - Create TransaksiDetail record (untuk setiap item)
   - Kurangi stok produk
   - Kurangi saldo kartu (jika kartu ID)
   ↓
4. Server redirect ke: /transaksi/confirmation/{id}
   ↓
5. TAMPIL: confirmation.blade.php (SUCCESS PAGE + STRUK)
```

### Tampilan halaman:

```
┌─────────────────────────────────────────────────────────┐
│                                                           │
│  ✓ PEMBAYARAN BERHASIL!                                 │
│  ✓ Transaksi telah diproses dan stok sudah berkurang   │
│                                                           │
│  ┌─────────────────────────────────────────────────┐   │
│  │                                                   │   │
│  │        [COOL E-BILL]                           │   │
│  │      STRUK PEMBAYARAN                          │   │
│  │                                                   │   │
│  │  Kode Transaksi: TRX-202607181235-456         │   │
│  │  Tanggal: 18/07/2026 12:35                     │   │
│  │  Kasir: Administrator                          │   │
│  │  Metode: 🆔 KARTU ID                           │   │
│  │  Kartu: card_001                               │   │
│  │                                                   │   │
│  │  ─────────────────────────────────────────────  │   │
│  │  Daftar Barang                                  │   │
│  │  Nasi Goreng    5x Rp50.000 = Rp250.000       │   │
│  │  Mie Kuah       2x Rp35.000 = Rp70.000        │   │
│  │  ─────────────────────────────────────────────  │   │
│  │  TOTAL: Rp320,000                              │   │
│  │                                                   │   │
│  │  Terima Kasih Telah Berbelanja!                │   │
│  │  ─────────────────────────────────────────────  │   │
│  │                                                   │   │
│  └─────────────────────────────────────────────────┘   │
│                                                           │
│  [🖨️ Cetak Struk]  [✓ Selesai & Kembali]              │
│                                                           │
└─────────────────────────────────────────────────────────┘
```

### Pada halaman ini:
- Struk bisa dicetak dengan button "🖨️ Cetak Struk"
- Klik "✓ Selesai & Kembali" → Redirect ke `/transaksi/index` (daftar transaksi)

---

## 🔄 Complete Flow Visualization

```
TRANSAKSI BARU
create.blade.php
│
├─ User pilih produk
│  └─ Masuk ke keranjang
│
└─ User pilih metode pembayaran
   │
   ├─ 💵 TUNAI
   │  └─ Langsung ke invoice.blade.php
   │     └─ Edit struk
   │        └─ Confirm
   │           └─ confirmation.blade.php ✓ SUKSES
   │              └─ Cetak/Selesai
   │
   └─ 🆔 KARTU ID
      └─ search-card.blade.php ⭐ INI DI SINI
         ├─ Search kartu (AJAX)
         │  └─ Results muncul
         │
         └─ Klik "Gunakan Kartu Ini"
            └─ invoice.blade.php
               └─ Edit struk
                  └─ Confirm
                     └─ confirmation.blade.php ✓ SUKSES
                        └─ Cetak/Selesai
```

---

## 📌 RINGKASAN: Di Bagian Mana search-card.blade.php Tampil?

**JAWAB: Halaman search-card.blade.php tampil SETELAH:**
1. User di halaman transaksi/create
2. User pilih produk
3. User klik tombol **"🆔 Kartu ID"**

**Maka sistem akan:**
- Simpan cart ke session
- Redirect ke /transaksi/search-card
- **Tampilkan halaman PENCARIAN KARTU** (search-card.blade.php)

**Dari halaman itu user bisa:**
- Search kartu by username atau ID
- Pilih kartu yang mau digunakan
- Redirect otomatis ke invoice.blade.php untuk edit struk
- Confirm pembayaran
- Lihat confirmation page dengan struk

---

## 🔗 Routes Summary

| URL | View | Keterangan |
|-----|------|-----------|
| `/transaksi/create` | `create.blade.php` | Halaman awal pilih produk |
| `/transaksi/select-payment` | (POST only) | Process pilihan metode |
| `/transaksi/search-card` | `search-card.blade.php` | ⭐ **HALAMAN CARI KARTU** |
| `/transaksi/find-card` | (AJAX JSON) | Return kartu yang cocok |
| `/transaksi/select-card` | (POST only) | Process pilihan kartu |
| `/transaksi/invoice` | `invoice.blade.php` | Halaman struk editable |
| `/transaksi/confirm` | (POST only) | Process konfirmasi |
| `/transaksi/confirmation/{id}` | `confirmation.blade.php` | Halaman sukses + struk |
| `/transaksi/index` | `index.blade.php` | Daftar transaksi |

