# Coole-Bill POS - REST API Documentation

## Base URL
```
http://your-domain.com/api/v1
```

## Authentication
API menggunakan Laravel Sanctum untuk authentication. Setiap request (kecuali login) harus menyertakan Bearer Token di header.

### Header Format
```
Authorization: Bearer {your-token}
Content-Type: application/json
Accept: application/json
```

---

## 📋 Response Format

### Success Response
```json
{
    "success": true,
    "message": "Operasi berhasil",
    "data": {
        // data response
    }
}
```

### Error Response
```json
{
    "success": false,
    "message": "Pesan error",
    "errors": {
        // detail errors (untuk validasi)
    }
}
```

### Paginated Response
```json
{
    "success": true,
    "message": "Data berhasil diambil",
    "data": [
        // array of items
    ],
    "meta": {
        "current_page": 1,
        "last_page": 5,
        "per_page": 15,
        "total": 75
    }
}
```

---

## 🔐 Authentication Endpoints

### 1. Login
Mendapatkan access token untuk authentication.

**Endpoint:** `POST /api/v1/login`

**Request Body:**
```json
{
    "email": "admin@example.com",
    "password": "password123"
}
```

**Response Success (200):**
```json
{
    "success": true,
    "message": "Login berhasil",
    "data": {
        "user": {
            "id": 1,
            "name": "Admin User",
            "email": "admin@example.com",
            "username": "admin",
            "role": "admin"
        },
        "token": "1|abc123...",
        "token_type": "Bearer"
    }
}
```

**Response Error (422):**
```json
{
    "success": false,
    "message": "The given data was invalid.",
    "errors": {
        "email": ["Kredensial yang diberikan tidak valid."]
    }
}
```

---

### 2. Logout
Menghapus access token saat ini.

**Endpoint:** `POST /api/v1/logout`

**Headers:** `Authorization: Bearer {token}`

**Response Success (200):**
```json
{
    "success": true,
    "message": "Logout berhasil"
}
```

---

### 3. Get Current User
Mendapatkan informasi user yang sedang login.

**Endpoint:** `GET /api/v1/me`

**Headers:** `Authorization: Bearer {token}`

**Response Success (200):**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "name": "Admin User",
        "email": "admin@example.com",
        "username": "admin",
        "role": "admin"
    }
}
```

---

## 📦 Products Endpoints

### 1. Get All Products
Mendapatkan daftar semua produk dengan pagination.

**Endpoint:** `GET /api/v1/products`

**Headers:** `Authorization: Bearer {token}`

**Query Parameters:**
- `per_page` (optional, default: 15) - Jumlah item per halaman
- `kategori_id` (optional) - Filter by kategori ID
- `search` (optional) - Cari berdasarkan nama atau barcode
- `low_stock` (optional, true/false) - Filter produk stok rendah (≤5)

**Example Request:**
```
GET /api/v1/products?per_page=10&kategori_id=1&search=indomie
```

**Response Success (200):**
```json
{
    "success": true,
    "message": "Data produk berhasil diambil",
    "data": [
        {
            "id": 1,
            "nama": "Indomie Goreng",
            "kategori_id": 1,
            "harga": 3000,
            "stok": 100,
            "barcode": "8992388101015",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z",
            "kategori": {
                "id": 1,
                "nama": "Makanan"
            }
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 1,
        "per_page": 10,
        "total": 5
    }
}
```

---

### 2. Get Single Product
Mendapatkan detail satu produk.

**Endpoint:** `GET /api/v1/products/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response Success (200):**
```json
{
    "success": true,
    "message": "Data produk berhasil diambil",
    "data": {
        "id": 1,
        "nama": "Indomie Goreng",
        "kategori_id": 1,
        "harga": 3000,
        "stok": 100,
        "barcode": "8992388101015",
        "kategori": {
            "id": 1,
            "nama": "Makanan"
        }
    }
}
```

**Response Error (404):**
```json
{
    "success": false,
    "message": "Produk tidak ditemukan"
}
```

---

### 3. Create Product
Menambahkan produk baru.

**Endpoint:** `POST /api/v1/products`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "nama": "Indomie Goreng",
    "kategori_id": 1,
    "harga": 3000,
    "stok": 100,
    "barcode": "8992388101015"
}
```

**Validation Rules:**
- `nama`: required, string, max 255 characters
- `kategori_id`: required, must exist in kategoris table
- `harga`: required, numeric, min 0
- `stok`: required, integer, min 0
- `barcode`: optional, string, unique

**Response Success (201):**
```json
{
    "success": true,
    "message": "Produk berhasil ditambahkan",
    "data": {
        "id": 1,
        "nama": "Indomie Goreng",
        "kategori_id": 1,
        "harga": 3000,
        "stok": 100,
        "barcode": "8992388101015",
        "kategori": {
            "id": 1,
            "nama": "Makanan"
        }
    }
}
```

---

### 4. Update Product
Mengupdate produk yang sudah ada.

**Endpoint:** `PUT /api/v1/products/{id}` atau `PATCH /api/v1/products/{id}`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "nama": "Indomie Goreng Special",
    "harga": 3500,
    "stok": 150
}
```

**Note:** Semua field optional untuk update

**Response Success (200):**
```json
{
    "success": true,
    "message": "Produk berhasil diupdate",
    "data": {
        "id": 1,
        "nama": "Indomie Goreng Special",
        "kategori_id": 1,
        "harga": 3500,
        "stok": 150,
        "barcode": "8992388101015"
    }
}
```

---

### 5. Delete Product
Menghapus produk.

**Endpoint:** `DELETE /api/v1/products/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response Success (200):**
```json
{
    "success": true,
    "message": "Produk berhasil dihapus"
}
```

---

## 🏷️ Categories Endpoints

### 1. Get All Categories
Mendapatkan daftar semua kategori.

**Endpoint:** `GET /api/v1/categories`

**Headers:** `Authorization: Bearer {token}`

**Response Success (200):**
```json
{
    "success": true,
    "message": "Data kategori berhasil diambil",
    "data": [
        {
            "id": 1,
            "nama": "Makanan",
            "produks_count": 25,
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    ]
}
```

---

### 2. Get Single Category
Mendapatkan detail satu kategori.

**Endpoint:** `GET /api/v1/categories/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response Success (200):**
```json
{
    "success": true,
    "message": "Data kategori berhasil diambil",
    "data": {
        "id": 1,
        "nama": "Makanan",
        "produks_count": 25
    }
}
```

---

### 3. Create Category
Menambahkan kategori baru.

**Endpoint:** `POST /api/v1/categories`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "nama": "Minuman"
}
```

**Response Success (201):**
```json
{
    "success": true,
    "message": "Kategori berhasil ditambahkan",
    "data": {
        "id": 2,
        "nama": "Minuman"
    }
}
```

---

### 4. Update Category
Mengupdate kategori.

**Endpoint:** `PUT /api/v1/categories/{id}` atau `PATCH /api/v1/categories/{id}`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "nama": "Minuman Segar"
}
```

**Response Success (200):**
```json
{
    "success": true,
    "message": "Kategori berhasil diupdate",
    "data": {
        "id": 2,
        "nama": "Minuman Segar"
    }
}
```

---

### 5. Delete Category
Menghapus kategori.

**Endpoint:** `DELETE /api/v1/categories/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response Success (200):**
```json
{
    "success": true,
    "message": "Kategori berhasil dihapus"
}
```

**Response Error (400):**
```json
{
    "success": false,
    "message": "Kategori tidak dapat dihapus karena masih memiliki produk"
}
```

---

## 💳 Transactions Endpoints

### 1. Get All Transactions
Mendapatkan daftar transaksi dengan pagination.

**Endpoint:** `GET /api/v1/transactions`

**Headers:** `Authorization: Bearer {token}`

**Query Parameters:**
- `per_page` (optional, default: 15) - Jumlah item per halaman
- `start_date` (optional, YYYY-MM-DD) - Filter tanggal mulai
- `end_date` (optional, YYYY-MM-DD) - Filter tanggal akhir
- `metode_pembayaran` (optional) - Filter metode pembayaran
- `user_id` (optional) - Filter by kasir

**Example Request:**
```
GET /api/v1/transactions?per_page=10&start_date=2024-01-01&end_date=2024-01-31
```

**Response Success (200):**
```json
{
    "success": true,
    "message": "Data transaksi berhasil diambil",
    "data": [
        {
            "id": 1,
            "kode_transaksi": "TRX-20240101-0001",
            "user_id": 1,
            "subtotal": 30000,
            "diskon": 0,
            "total": 30000,
            "jumlah_bayar": 50000,
            "kembalian": 20000,
            "metode_pembayaran": "tunai",
            "payment_card_id": null,
            "created_at": "2024-01-01T10:30:00.000000Z",
            "user": {
                "id": 1,
                "name": "Kasir 1"
            },
            "payment_card": null,
            "details": [
                {
                    "id": 1,
                    "produk_id": 1,
                    "jumlah": 10,
                    "harga_satuan": 3000,
                    "subtotal": 30000,
                    "produk": {
                        "id": 1,
                        "nama": "Indomie Goreng"
                    }
                }
            ]
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 3,
        "per_page": 10,
        "total": 25
    }
}
```

---

### 2. Get Single Transaction
Mendapatkan detail satu transaksi.

**Endpoint:** `GET /api/v1/transactions/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response Success (200):**
```json
{
    "success": true,
    "message": "Data transaksi berhasil diambil",
    "data": {
        "id": 1,
        "kode_transaksi": "TRX-20240101-0001",
        "subtotal": 30000,
        "diskon": 0,
        "total": 30000,
        "jumlah_bayar": 50000,
        "kembalian": 20000,
        "metode_pembayaran": "tunai",
        "user": {
            "id": 1,
            "name": "Kasir 1"
        },
        "details": [
            {
                "id": 1,
                "produk_id": 1,
                "jumlah": 10,
                "harga_satuan": 3000,
                "subtotal": 30000,
                "produk": {
                    "id": 1,
                    "nama": "Indomie Goreng"
                }
            }
        ]
    }
}
```

---

### 3. Create Transaction
Membuat transaksi baru.

**Endpoint:** `POST /api/v1/transactions`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "items": [
        {
            "produk_id": 1,
            "jumlah": 10
        },
        {
            "produk_id": 2,
            "jumlah": 5
        }
    ],
    "metode_pembayaran": "tunai",
    "payment_card_id": null,
    "jumlah_bayar": 50000,
    "diskon": 0
}
```

**Validation Rules:**
- `items`: required, array, min 1 item
- `items.*.produk_id`: required, must exist in produks table
- `items.*.jumlah`: required, integer, min 1
- `metode_pembayaran`: required, must be one of: tunai, kartu_debit, kartu_kredit, qris, e_wallet
- `payment_card_id`: optional, must exist in payment_cards table
- `jumlah_bayar`: required, numeric, min 0
- `diskon`: optional, numeric, min 0

**Response Success (201):**
```json
{
    "success": true,
    "message": "Transaksi berhasil dibuat",
    "data": {
        "id": 1,
        "kode_transaksi": "TRX-20240101-0001",
        "subtotal": 30000,
        "diskon": 0,
        "total": 30000,
        "jumlah_bayar": 50000,
        "kembalian": 20000,
        "metode_pembayaran": "tunai"
    }
}
```

**Response Error (400):**
```json
{
    "success": false,
    "message": "Transaksi gagal: Stok Indomie Goreng tidak mencukupi"
}
```

---

### 4. Get Transaction Statistics
Mendapatkan statistik transaksi.

**Endpoint:** `GET /api/v1/transactions/statistics/summary`

**Headers:** `Authorization: Bearer {token}`

**Query Parameters:**
- `start_date` (optional, YYYY-MM-DD) - Default: 30 hari lalu
- `end_date` (optional, YYYY-MM-DD) - Default: hari ini

**Response Success (200):**
```json
{
    "success": true,
    "message": "Statistik transaksi berhasil diambil",
    "data": {
        "total_transaksi": 150,
        "total_penjualan": 15000000,
        "rata_rata_transaksi": 100000,
        "metode_pembayaran": [
            {
                "metode_pembayaran": "tunai",
                "count": 80,
                "total": 8000000
            },
            {
                "metode_pembayaran": "kartu_debit",
                "count": 70,
                "total": 7000000
            }
        ]
    }
}
```

---

## 👥 Users Endpoints

### 1. Get All Users
Mendapatkan daftar semua users.

**Endpoint:** `GET /api/v1/users`

**Headers:** `Authorization: Bearer {token}`

**Query Parameters:**
- `per_page` (optional, default: 15)
- `role` (optional) - Filter by role (admin/kasir)

**Response Success (200):**
```json
{
    "success": true,
    "message": "Data user berhasil diambil",
    "data": [
        {
            "id": 1,
            "name": "Admin User",
            "email": "admin@example.com",
            "username": "admin",
            "role": "admin",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    ],
    "meta": {
        "current_page": 1,
        "last_page": 1,
        "per_page": 15,
        "total": 5
    }
}
```

---

### 2. Get Single User
Mendapatkan detail satu user.

**Endpoint:** `GET /api/v1/users/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response Success (200):**
```json
{
    "success": true,
    "message": "Data user berhasil diambil",
    "data": {
        "id": 1,
        "name": "Admin User",
        "email": "admin@example.com",
        "username": "admin",
        "role": "admin",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

---

### 3. Create User
Menambahkan user baru (Admin only).

**Endpoint:** `POST /api/v1/users`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "name": "Kasir Baru",
    "email": "kasir@example.com",
    "username": "kasir01",
    "password": "password123",
    "role": "kasir"
}
```

**Validation Rules:**
- `name`: required, string, max 255
- `email`: required, email, unique
- `username`: required, string, unique
- `password`: required, string, min 6
- `role`: required, must be 'admin' or 'kasir'

**Response Success (201):**
```json
{
    "success": true,
    "message": "User berhasil ditambahkan",
    "data": {
        "id": 2,
        "name": "Kasir Baru",
        "email": "kasir@example.com",
        "username": "kasir01",
        "role": "kasir",
        "created_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

---

### 4. Update User
Mengupdate user.

**Endpoint:** `PUT /api/v1/users/{id}` atau `PATCH /api/v1/users/{id}`

**Headers:** `Authorization: Bearer {token}`

**Request Body:**
```json
{
    "name": "Kasir Updated",
    "password": "newpassword123"
}
```

**Note:** Semua field optional. Password hanya diupdate jika dikirim.

**Response Success (200):**
```json
{
    "success": true,
    "message": "User berhasil diupdate",
    "data": {
        "id": 2,
        "name": "Kasir Updated",
        "email": "kasir@example.com",
        "username": "kasir01",
        "role": "kasir",
        "updated_at": "2024-01-02T00:00:00.000000Z"
    }
}
```

---

### 5. Delete User
Menghapus user.

**Endpoint:** `DELETE /api/v1/users/{id}`

**Headers:** `Authorization: Bearer {token}`

**Response Success (200):**
```json
{
    "success": true,
    "message": "User berhasil dihapus"
}
```

**Response Error (400):**
```json
{
    "success": false,
    "message": "Tidak dapat menghapus user sendiri"
}
```

---

## 🔍 Testing API dengan cURL

### Login Example
```bash
curl -X POST http://your-domain.com/api/v1/login \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "admin@example.com",
    "password": "password"
  }'
```

### Get Products Example
```bash
curl -X GET http://your-domain.com/api/v1/products \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

### Create Product Example
```bash
curl -X POST http://your-domain.com/api/v1/products \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "nama": "Indomie Goreng",
    "kategori_id": 1,
    "harga": 3000,
    "stok": 100,
    "barcode": "8992388101015"
  }'
```

### Create Transaction Example
```bash
curl -X POST http://your-domain.com/api/v1/transactions \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "items": [
      {"produk_id": 1, "jumlah": 10},
      {"produk_id": 2, "jumlah": 5}
    ],
    "metode_pembayaran": "tunai",
    "jumlah_bayar": 50000,
    "diskon": 0
  }'
```

---

## 📝 Error Codes

| HTTP Code | Deskripsi |
|-----------|-----------|
| 200 | OK - Request berhasil |
| 201 | Created - Resource berhasil dibuat |
| 400 | Bad Request - Request tidak valid |
| 401 | Unauthorized - Token tidak valid atau expired |
| 404 | Not Found - Resource tidak ditemukan |
| 422 | Unprocessable Entity - Validasi gagal |
| 500 | Internal Server Error - Error di server |

---

## 💡 Tips & Best Practices

1. **Token Management**
   - Simpan token dengan aman
   - Token akan expired setelah logout
   - Satu user bisa memiliki multiple tokens

2. **Pagination**
   - Default per_page adalah 15
   - Maximum per_page adalah 100
   - Gunakan meta data untuk navigasi halaman

3. **Rate Limiting**
   - API memiliki rate limit 60 requests per menit per user
   - Header `X-RateLimit-Remaining` menunjukkan sisa quota

4. **Validation Errors**
   - Selalu cek field `errors` untuk detail validasi
   - Field name sebagai key, array pesan error sebagai value

5. **Stock Management**
   - Transaksi otomatis mengurangi stok produk
   - Cek stok sebelum membuat transaksi
   - Gunakan parameter `low_stock=true` untuk monitoring

---

## 📞 Support

Jika ada pertanyaan atau masalah dengan API, hubungi tim development atau buat issue di repository project.

---

**Version:** 1.0  
**Last Updated:** {{ date('Y-m-d') }}  
**Maintained by:** Coole-Bill Development Team
