# 🔍 PAYMENT FLOW DEBUG GUIDE

## Jika Tidak Berfungsi - Ikuti Guide Ini

### PENTING: Buka Browser Console (F12)

**Tekan F12 di browser Anda**

Anda akan melihat 4 tab:
- Elements (klik sini jika perlu lihat HTML)
- Console ← **KLIK INI** untuk melihat error/log
- Sources
- Network (bisa lihat request/response)

---

## STEP-BY-STEP DEBUGGING

### 1️⃣ OPEN TRANSAKSI PAGE

Buka: `http://localhost/transaksi/create`

Klik F12, masuk ke **Console tab**

---

### 2️⃣ ADD PRODUCT TO CART

Klik salah satu produk, misal "Nasi Goreng"

**Di Console seharusnya TIDAK ada error**

Lihat di keranjang (kanan) apakah produk muncul ✓

---

### 3️⃣ CHECK STATUS MESSAGE

Di bawah Total, ada kotak biru dengan status:

| Status | Berarti |
|--------|---------|
| 📝 Pilih produk terlebih dahulu | Keranjang kosong |
| ⚠️ Pilih metode pembayaran | Ada produk, tapi belum pilih metode |
| ✅ Siap! Metode: 💵 Tunai | Ready - bisa klik Proses Pembayaran |

---

### 4️⃣ SELECT PAYMENT METHOD

Klik salah satu:
- `[💵 Tunai]`
- `[🆔 Kartu ID]`

**Di Console harusnya muncul:**
```
✓ Payment method selected: tunai
(atau: kartu_id)
```

**Jika ada error, copy ke sini untuk debugging**

---

### 5️⃣ CLICK "PROSES PEMBAYARAN"

Klik tombol `[Proses Pembayaran]`

**Di Console harusnya muncul:**
```
=== PROSES PEMBAYARAN START ===
selectedPaymentMethod: tunai
cartArray length: 1
cartArray: [{...}]
Items prepared: [{...}]
Subtotal: 25000
Total: 25000
Method: tunai
Form created, submitting to: http://localhost/transaksi/select-payment
Form submitted
```

**Lalu halaman redirect ke:**
- Jika Tunai → `/transaksi/invoice` (halaman struk editable)
- Jika Kartu ID → `/transaksi/search-card` (halaman cari kartu)

---

## ⚠️ COMMON ISSUES

### ISSUE #1: Tombol "Proses Pembayaran" Disabled (Gray)

**Penyebab:** Keranjang kosong ATAU metode pembayaran belum dipilih

**Fix:**
1. ✓ Pilih produk (ke keranjang)
2. ✓ Pilih metode pembayaran (Tunai atau Kartu ID)
3. ✓ Tombol akan enable (warna orange)

---

### ISSUE #2: Klik "Proses Pembayaran" Tidak Terjadi Apa-apa

**Penyebab:** Ada error di console

**Debug:**
1. Buka Console (F12)
2. Cari error message
3. Copy error dan kirim ke developer

**Possible errors:**
- ❌ Keranjang masih kosong!
- ❌ Pilih metode pembayaran terlebih dahulu!
- CSRF token error

---

### ISSUE #3: Redirect Tidak Terjadi

**Penyebab:** Error di server (di console Network tab)

**Debug:**
1. Buka Console → Console tab
2. Klik "Proses Pembayaran"
3. Switch ke **Network tab**
4. Lihat request "select-payment"
5. Check response (ada error message?)

---

## 🧪 TESTING CHECKLIST

Sebelum submit ke developer, pastikan:

- [ ] Browser console terbuka (F12)
- [ ] Produk bisa ditambah ke keranjang
- [ ] Status message menunjukkan "Pilih metode pembayaran"
- [ ] Bisa klik tombol Tunai/Kartu ID
- [ ] Status message berubah ke "✅ Siap!"
- [ ] Tombol "Proses Pembayaran" enable (tidak gray)
- [ ] Klik tombol tidak ada error di console
- [ ] Halaman redirect ke struk (invoice) atau kartu search

---

## 📸 SCREENSHOT UNTUK DEVELOPER

Jika ada masalah, screenshot:

1. **Full page screenshot** (termasuk keranjang dan status)
2. **Console output** (F12 → Console tab, scroll keatas catat semua message)
3. **Error message** jika ada

---

## 🔧 MANUAL TESTING FLOW

### FLOW 1: TUNAI

```
1. Open: /transaksi/create
2. Add product: Nasi Goreng (qty 2)
3. Check cart shows: Nasi Goreng x2
4. Click: 💵 Tunai
5. Status shows: ✅ Siap! Metode: 💵 Tunai
6. Click: Proses Pembayaran
   → Redirect to: /transaksi/invoice?method=tunai
7. See struk with item list, can edit qty/price
8. Click: Konfirmasi Pembayaran
   → Redirect to: /transaksi/confirmation/{id}
9. See receipt with transaction details
```

### FLOW 2: KARTU ID

```
1. Open: /transaksi/create
2. Add product: Mie Ayam (qty 1)
3. Check cart shows: Mie Ayam x1
4. Click: 🆔 Kartu ID
5. Status shows: ✅ Siap! Metode: 🆔 Kartu ID
6. Click: Proses Pembayaran
   → Redirect to: /transaksi/search-card
7. Search card by username or ID
8. Click: Select card
   → Redirect to: /transaksi/invoice?method=kartu_id
9. See struk with card info
10. Click: Konfirmasi Pembayaran
    → Deduct balance + reduce stock
    → Redirect to: /transaksi/confirmation/{id}
```

---

## 💬 WHAT TO INCLUDE IN BUG REPORT

Jika ada error:

```
System: Windows
Browser: Chrome/Firefox/Edge
URL: http://localhost/transaksi/create

ISSUE: [Deskripsi singkat masalahnya]

STEPS:
1. ...
2. ...
3. ...

EXPECTED: [Apa yang seharusnya terjadi]
ACTUAL: [Apa yang benar-benar terjadi]

CONSOLE ERROR:
[Copy-paste console output]

SCREENSHOT: [Attached]
```

---

## 🎯 VERIFICATION CHECKLIST

✅ **Checkout dengan Tunai:**
- [ ] Data items terkirim lengkap (qty, harga, subtotal)
- [ ] Redirect ke invoice page
- [ ] Struk menampilkan items dengan benar
- [ ] Bisa edit qty/price di struk
- [ ] Klik Konfirmasi berhasil
- [ ] Stock berkurang di database

✅ **Checkout dengan Kartu ID:**
- [ ] Data items terkirim lengkap
- [ ] Redirect ke search-card page
- [ ] Bisa cari kartu by username/ID
- [ ] Bisa pilih kartu
- [ ] Redirect ke invoice dengan card info
- [ ] Klik Konfirmasi berhasil
- [ ] Stock berkurang di database
- [ ] Balance kartu berkurang

✅ **Confirmation Page:**
- [ ] Muncul setelah pembayaran sukses
- [ ] Receipt terlihat lengkap
- [ ] Tombol print berfungsi
- [ ] Tombol back redirect ke list

---

## 📞 NEED HELP?

Provide:
1. Browser console output (F12)
2. Full page screenshot
3. Step mana yang gagal
4. Error message (jika ada)

Then we can debug lebih cepat! 🚀
