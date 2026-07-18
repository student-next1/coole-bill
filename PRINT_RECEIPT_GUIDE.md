# 🖨️ CARA CETAK STRUK DARI RIWAYAT TRANSAKSI

## Fitur Baru: Print Receipt Button

Sekarang user dapat **mencetak struk untuk transaksi yang sudah selesai** dari halaman Riwayat Transaksi.

---

## 📋 STEP-BY-STEP GUIDE

### STEP 1: Buka Riwayat Transaksi
- Klik menu **Transaksi** di sidebar
- Atau akses: `/transaksi` 
- Anda akan melihat daftar semua transaksi

```
Riwayat Transaksi
─────────────────
[Transaksi Baru] tombol

Stat Cards:
- Total Transaksi: 10
- Total Penjualan: Rp xxx
- Rata-rata: Rp xxx

Tabel Transaksi:
Kode | Kasir | Total | Metode | Aksi
─────────────────────────────────────
TRX-...    | John  | 100k  | Tunai   | [Detail]
TRX-...    | Jane  | 250k  | Kartu   | [Detail]
...
```

---

### STEP 2: Pilih Transaksi

Cari transaksi yang ingin dicetak stuknya dari tabel:
- **Kolom Kode Transaksi**: Nomor unik transaksi
- **Kolom Total**: Jumlah yang dibayarkan
- **Kolom Metode**: Tunai atau Kartu ID

Klik tombol **[Detail]** pada baris transaksi yang diinginkan.

---

### STEP 3: Buka Detail Modal

Setelah klik Detail, akan muncul pop-up (modal) berisi:

```
┌─────────────────────────────────┐
│ Detail Transaksi                │
├─────────────────────────────────┤
│                                 │
│ Kode Transaksi: TRX-20260718... │
│ Total: Rp 100.000              │
│                                 │
│ Jumlah Item: 2                 │
│ Waktu: 18/07/2026 14:30        │
│                                 │
│ Pembayaran Kartu:              │
│ John Doe (Kartu ID)            │ (jika pakai kartu)
│                                 │
├─────────────────────────────────┤
│ [🖨️ Cetak Struk]  [Tutup]      │
└─────────────────────────────────┘
```

---

### STEP 4: Klik Tombol "🖨️ Cetak Struk"

Di dalam modal, ada 2 tombol:
- **Kiri**: 🖨️ Cetak Struk (biru) ← **KLIK INI**
- **Kanan**: Tutup (abu-abu)

Klik tombol **[🖨️ Cetak Struk]**.

---

### STEP 5: Receipt Page Terbuka

Halaman struk/receipt akan terbuka di **window baru** dengan tampilan:

```
╔════════════════════════════════╗
║     COOL E-BILL                ║
║   STRUK PEMBAYARAN             ║
║   Smart POS System             ║
╠════════════════════════════════╣
║ Kode Transaksi: TRX-...        ║
║ Tanggal: 18/07/2026 14:30      ║
║ Kasir: John Doe                ║
║ Metode: Tunai / Kartu ID       ║
╠════════════════════════════════╣
║ DAFTAR BARANG:                 ║
║                                ║
║ Nasi Goreng        1x  Rp25k   ║
║                              25k║
║ Mie Ayam           2x  Rp20k   ║
║                              40k║
╠════════════════════════════════╣
║ Subtotal:             Rp65.000 ║
║ TOTAL:                Rp65.000 ║
╠════════════════════════════════╣
║ Terima Kasih Telah Berbelanja   ║
║ Simpan struk ini sebagai bukti  ║
╚════════════════════════════════╝

[🖨️ Cetak]  [Transaksi Baru]  [Lihat Riwayat]
```

---

### STEP 6: Print Dialog Akan Muncul

Browser akan menampilkan **Print Dialog** secara otomatis.

**Opsi Print:**

```
Printer:
[ Pilih Printer ▼ ]
  - Microsoft Print to PDF (untuk save as PDF)
  - Printer fisik Anda
  - Print to OneNote
  - dst

Ukuran Kertas:
[ A4 / Custom ▼ ]

Orientasi:
[ Portrait ] / [ Landscape ]

Opsi lainnya:
□ Headers dan Footers
□ Background graphics
dst
```

---

### STEP 7: Konfigurasi Print (Opsional)

**Untuk POS Printer (80mm):**
- Pilih printer yang sesuai
- Set orientasi: **Portrait**
- Biarkan ukuran otomatis

**Untuk PDF:**
- Pilih: **Microsoft Print to PDF**
- Klik **Save**
- File akan tersimpan di Downloads

**Untuk Printer Biasa:**
- Pilih printer fisik Anda
- Atur ukuran kertas
- Klik **Print**

---

### STEP 8: Cetak!

Klik tombol **[Print]** atau **[Save]** (tergantung pilihan Anda).

**Selesai!** ✓ Struk akan tercetak atau tersimpan.

---

## 💡 TIPS & TRICKS

### Cetak ke PDF (Menyimpan Struk Digital)
1. Klik Detail transaksi
2. Klik Cetak Struk
3. Di Print Dialog, pilih: **"Microsoft Print to PDF"**
4. Klik **[Save]**
5. Pilih folder dan nama file
6. Struk tersimpan sebagai PDF ✓

### Cetak ke Printer Thermal (80mm)
1. Pastikan printer thermal sudah terhubung
2. Di Print Dialog, pilih printer thermal
3. Ukuran kertas otomatis menyesuaikan 80mm
4. Klik **[Print]**

### Print Preview Sebelum Cetak
- Lihat preview di print dialog
- Jika kurang memuaskan, ubah setting
- Pastikan struk terlihat lengkap

### Close Receipt Window
- Setelah selesai print
- Tutup window receipt dengan ❌ (close button)
- Kembali ke halaman riwayat transaksi

---

## ✅ YANG DITAMPILKAN DI STRUK

✓ **COOLE-BILL** logo
✓ **Kode Transaksi** (nomor unik)
✓ **Tanggal & Waktu** (kapan transaksi terjadi)
✓ **Nama Kasir** (siapa yang proses)
✓ **Metode Pembayaran** (Tunai / Kartu ID)
✓ **Daftar Produk** dengan:
  - Nama produk
  - Jumlah (Qty)
  - Harga satuan
  - Subtotal per item
✓ **Total Pembayaran**
✓ **Footer** (ucapan terima kasih)

---

## 🔍 TROUBLESHOOTING

### Problem: Receipt window tidak terbuka
**Solusi:**
- Mungkin browser block pop-up
- Cek notification bar di browser
- Allow pop-up untuk situs ini
- Coba lagi

### Problem: Print dialog tidak muncul
**Solusi:**
- Tunggu beberapa saat
- Refresh page dan coba ulang
- Coba gunakan Ctrl+P manual

### Problem: Struk terlihat aneh/terpotong
**Solusi:**
- Ubah setting print:
  - Margins: Minimal/None
  - Background graphics: ON
  - Scale: 100%

### Problem: Mau print tapi printer tidak terdeteksi
**Solusi:**
- Cek printer sudah on dan terhubung
- Install driver printer
- Refresh page dan coba ulang

---

## 🎯 WORKFLOW LENGKAP

```
1. Buka Transaksi
   ↓
2. Lihat Riwayat Transaksi
   ↓
3. Klik [Detail] pada transaksi yang diinginkan
   ↓
4. Modal detail terbuka
   ↓
5. Klik [🖨️ Cetak Struk]
   ↓
6. Receipt page terbuka di window baru
   ↓
7. Print dialog muncul otomatis
   ↓
8. Atur setting printer
   ↓
9. Klik [Print] atau [Save]
   ↓
10. Selesai! ✓
```

---

## 📞 PERLU BANTUAN?

Jika ada masalah saat cetak:
- Screenshot halaman receipt
- Screenshot print dialog (jika ada error)
- Browser apa yang digunakan
- Share dengan developer 👍

---

## 🎉 FITUR LENGKAP SEKARANG

Saat membuat transaksi:
- ✓ Lihat struk setelah pembayaran → Bisa langsung cetak
- ✓ Di halaman confirmation

Saat lihat riwayat:
- ✓ Klik Detail → Cetak struk lama kapan saja
- ✓ Print ke PDF, Printer Thermal, atau Printer Biasa

**Fleksibel & mudah digunakan!** 🚀
