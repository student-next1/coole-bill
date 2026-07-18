# Payment Card System - Quick Start Guide

## 🚀 Getting Started (5 minutes)

### 1. Fresh Database Setup
```bash
php artisan migrate:fresh --seed
```
This will:
- Create all database tables (payment_cards, payment_card_transactions, etc.)
- Seed 5 test payment cards with initial balance
- Seed 12 sample products
- Create 2 test users

### 2. Test Users
**Admin:**
- Email: `admin@example.com`
- Password: `admin123`
- Access: Payment card management, settings

**Cashier:**
- Email: `user@example.com`
- Password: `user123`
- Access: Create transactions only

### 3. Test Payment Cards (Pre-seeded)
| Username | Holder Name | Initial Balance | Status |
|----------|-------------|-----------------|--------|
| card_001 | Andi Wijaya | Rp 1,000,000 | Active |
| card_002 | Budi Santoso | Rp 500,000 | Active |
| card_003 | Citra Dewi | Rp 750,000 | Active |
| card_004 | Dedi Hermawan | Rp 250,000 | Active |
| card_005 | Eka Putri | Rp 2,000,000 | Active |

## 💳 Quick Test Flow

### As Admin
1. Login with `admin@example.com / admin123`
2. Sidebar → Kartu Pembayaran
3. View 5 pre-seeded cards with balances
4. Click any card to see details
5. Try "Topup" button to add balance
6. View transaction history

### As Cashier / Customer
1. Login with `user@example.com / user123`
2. Dashboard → Buat Transaksi
3. Add 2-3 products to cart
4. Click "Proses Pembayaran"
5. Select "Kartu Pembayaran"
6. Search for card: type `card_001` or `Andi`
7. Click card in results
8. Confirm payment in modal
9. Transaction processed!
10. Check transaction list to verify

## 📊 Verify Payment Card Integration

### Check Database
```bash
php artisan tinker
>>> PaymentCard::count()        # Should show: 5
>>> Produk::count()             # Should show: 12
>>> Transaksi::count()          # Initially: 0
```

### Check Routes
```bash
# All these should return data/views
php artisan route:list | grep payment-cards
php artisan route:list | grep transaksi
```

### Check Controllers
- Payment card CRUD: `app/Http/Controllers/PaymentCardController.php`
- Transaction payment flow: `app/Http/Controllers/TransaksiController.php` (methods: selectPaymentMethod, selectCard, findCard, store)

## 🎯 Key Features to Test

### 1. Create New Payment Card
- Admin → Kartu Pembayaran → Tambah Kartu Baru
- Fill form, submit
- See auto-generated card code (CARD-YYYYMMDDHHiiss-RRRRR)

### 2. Search Payment Card During Checkout
- Create transaction → Select card payment method
- Type in search: card code, username, or holder name
- Results appear in real-time
- See balance indicator (✓ Cukup or ✗ Kurang)

### 3. Verify Balance Deduction
- Before: Note card balance
- Complete payment
- After: View card detail → Balance reduced
- Check "Riwayat" (History) to see transaction record

### 4. Verify Stock Deduction
- Before: Check product stock
- Complete transaction with that product
- After: Check product stock → Reduced

### 5. Transaction History
- View transaction list: See payment method, card holder, card code
- Click Detail: Modal shows payment card info
- Admin → Card → Riwayat: See all transactions for that card

## 🐛 Troubleshooting Quick Fixes

### Payment card not showing in sidebar
```bash
php artisan config:cache
# Then refresh browser
```

### Card search returns empty
- Verify card status is 'active' (not 'inactive' or 'blocked')
- Type at least 2 characters
- Check: admin page shows card list

### Balance not deducting
- Check PaymentCardTransaction created: `PaymentCardTransaction::latest()->first()`
- Verify card ID in transaction: `Transaksi::latest()->first()->payment_card_id`

### Stock not deducting
- Check TransaksiDetail created
- Verify Produk stok was decremented
- Check: `Produk::find(1)->stok` shows reduced value

## 📁 File Structure

### Models
- `app/Models/PaymentCard.php` - Card info & balance methods
- `app/Models/PaymentCardTransaction.php` - Audit trail

### Controllers
- `app/Http/Controllers/PaymentCardController.php` - CRUD & management
- `app/Http/Controllers/TransaksiController.php` - Payment flow

### Views
- `resources/views/payment-cards/` - 6 card management views
- `resources/views/transaksi/` - 3 payment flow views

### Routes
- `/payment-cards/*` - 11 card management routes
- `/transaksi/*` - 6 transaction payment routes

### Database
- `database/migrations/` - 3 payment card migrations
- `database/seeders/PaymentCardSeeder.php` - Test data

## 📊 Expected Results After First Transaction

### Payment Card (e.g., card_001)
- Initial balance: Rp 1,000,000
- After Rp 250,000 transaction: Rp 750,000
- Check: Admin → Kartu Pembayaran → card_001 → Riwayat

### Product Stock
- If bought 5 units: Stock decreases by 5
- Check: Admin → Produk → [Product]

### Transaction Record
- Shows card payment method badge
- Shows holder name and card code
- Click Detail to see payment info
- Check: Dashboard → Transaksi

## 🔍 Manual Testing Commands

```bash
# Start fresh
php artisan migrate:fresh --seed

# Run dev server (if using artisan)
php artisan serve

# Access application
# URL: http://localhost:8000
# Admin login: admin@example.com / admin123

# Verify setup in tinker
php artisan tinker
>>> PaymentCard::all()
>>> PaymentCard::find(1)->saldo
>>> Transaksi::with('paymentCard')->latest()->first()
>>> PaymentCardTransaction::where('type', 'purchase')->latest()->first()
```

## 📖 Documentation Files

- **PAYMENT_CARD_SYSTEM.md** - Complete documentation
- **PAYMENT_CARD_TESTING.md** - 32 test scenarios
- **IMPLEMENTATION_SUMMARY.md** - Project summary
- **This file (PAYMENT_CARD_QUICKSTART.md)** - Quick reference

## ✅ System Status

- ✅ Database migrations: Complete
- ✅ Models & relationships: Complete
- ✅ CRUD operations: Complete
- ✅ Payment flow: Complete
- ✅ Stock deduction: Complete
- ✅ Balance tracking: Complete
- ✅ Views & UI: Complete
- ✅ Test data: 5 cards seeded
- ✅ Documentation: Comprehensive
- ✅ Ready for testing: YES

## 🎯 Next Test Step

1. Run: `php artisan migrate:fresh --seed`
2. Login as admin: `admin@example.com / admin123`
3. Go to: Sidebar → Kartu Pembayaran
4. See: 5 test payment cards with balances
5. Click: Any card → View details → Try "Topup" button
6. Success! ✅

## 💬 Need Help?

See troubleshooting section in:
- PAYMENT_CARD_SYSTEM.md → Troubleshooting
- PAYMENT_CARD_TESTING.md → Troubleshooting
- Error messages in `storage/logs/laravel.log`

---

**Ready to test?** Start with step 1: `php artisan migrate:fresh --seed` ✨
