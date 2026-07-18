# Payment Card System - Testing Guide

## Overview
Custom prepaid card payment system for Cool E-Bill POS. Customers can create cards with unique codes, manage balance, and use them for transactions.

## Test Cards (Pre-seeded)
| Username | Card Code | Holder Name | Initial Balance | Status |
|----------|-----------|-------------|-----------------|--------|
| card_001 | CARD-... | Andi Wijaya | Rp 1,000,000 | Active |
| card_002 | CARD-... | Budi Santoso | Rp 500,000 | Active |
| card_003 | CARD-... | Citra Dewi | Rp 750,000 | Active |
| card_004 | CARD-... | Dedi Hermawan | Rp 250,000 | Active |
| card_005 | CARD-... | Eka Putri | Rp 2,000,000 | Active |

## Test Scenarios

### 1. Create New Payment Card
**Path:** Admin → Kartu Pembayaran → Buat Kartu
1. Click "Tambah Kartu Baru"
2. Fill form:
   - Holder Name: [Test Name]
   - Username: [Optional, unique]
   - Initial Balance: 500000
   - Status: Active
3. Click "Simpan"
4. ✓ Card created with auto-generated code (CARD-YYYYMMDDHHiiss-RRRRR)
5. ✓ Barcode data field populated
6. ✓ Redirect to card detail page

### 2. View Payment Card List
**Path:** Admin → Kartu Pembayaran
1. See all active cards with:
   - Card Code (clickable for detail)
   - Holder Name
   - Current Balance (Rp format)
   - Username (if set)
   - Status
   - Last Used (if applicable)
2. ✓ Cards sorted by latest created
3. ✓ Pagination working (10 items per page)

### 3. Payment Card Detail & Print
**Path:** Admin → Kartu Pembayaran → [Card]
1. View complete card information:
   - Card code
   - Holder name
   - Username
   - Current balance
   - Card status
2. Click "Print Kartu" button
3. ✓ Print dialog opens
4. ✓ Card design shows barcode representation
5. ✓ Print format optimized for A6 card size

### 4. Topup Card Balance
**Path:** Admin → Kartu Pembayaran → [Card] → Topup
1. Enter amount: 250000
2. Click "Proses Topup"
3. ✓ Balance increases by amount
4. ✓ Transaction record created (type: topup)
5. ✓ Redirect to card detail with success message
6. ✓ Previous balance shown in transaction history

### 5. View Card Transaction History
**Path:** Admin → Kartu Pembayaran → [Card] → Riwayat Transaksi
1. See all transactions for card:
   - Type (purchase/topup/refund)
   - Description/Transaction Code
   - Amount (± format)
   - Balance Before
   - Balance After
   - Timestamp
2. ✓ Sorted by newest first
3. ✓ Color-coded by type (red=purchase, green=topup)

### 6. Edit Payment Card
**Path:** Admin → Kartu Pembayaran → [Card] → Edit
1. Change holder name, username, or status
2. Click "Simpan"
3. ✓ Changes saved
4. ✓ Redirect to card detail
5. ✓ Original card code unchanged

### 7. Delete Payment Card
**Path:** Admin → Kartu Pembayaran → [Card] → Delete
1. Click delete button
2. Confirm deletion
3. ✓ Card removed from system
4. ✓ Cannot be used in new transactions
5. ✓ History transactions remain intact

## Transaction Flow Testing

### 8. Checkout with Payment Card
**Path:** Dashboard → Buat Transaksi
1. Add products to cart (at least 2 items)
2. Click "Proses Pembayaran"
3. Select payment method: "Kartu Pembayaran"
4. ✓ Redirected to card search page

### 9. Search Payment Card
**Path:** Payment card search page
1. Test search by:
   - **Card Code:** Type "CARD-" prefix
   - **Username:** Type "card_001"
   - **Holder Name:** Type "Andi"
2. ✓ Results appear dynamically (300ms debounce)
3. ✓ Shows card holder, code, username, and balance
4. ✓ Shows "✓ Cukup" if balance sufficient
5. ✓ Shows "✗ Kurang" if balance insufficient

### 10. Confirm Payment
1. Click on a card with sufficient balance
2. Modal appears showing:
   - Card holder name and code
   - Order items
   - Subtotal, Tax, Total
   - Balance deduction notice
3. Click "Konfirmasi & Proses Pembayaran"
4. ✓ Transaction processed

### 11. Verify Stock Deduction
1. Before transaction: Note product stock (e.g., 50)
2. Complete transaction with 5 units
3. **Path:** Admin → Produk → [Product]
4. ✓ Stock reduced by 5 (now 45)
5. ✓ Stock deduction atomic with payment (both succeed/fail together)

### 12. Verify Balance Deduction
1. Before transaction: Note card balance (e.g., Rp 1,000,000)
2. Complete transaction for Rp 250,000
3. **Path:** Admin → Kartu Pembayaran → [Card]
4. ✓ Balance reduced to Rp 750,000
5. ✓ Transaction record created
6. ✓ Saldo before/after recorded

### 13. Transaction List Display
**Path:** Dashboard → Transaksi
1. View transaction table showing:
   - Transaction code
   - Cashier name
   - Total amount
   - Payment method (badge: Tunai/Transfer/Kartu)
   - Card holder name (for card payments)
   - Card code (for card payments)
   - Timestamp
2. Click "Detail" button
3. ✓ Modal shows payment card info for card transactions
4. ✓ Modal hides payment card info for cash/transfer

## Error Handling Tests

### 14. Insufficient Balance
1. Search and select card with balance < transaction total
2. ✓ Cannot select card (error message)
3. ✓ Or error shown at confirmation stage

### 15. Inactive Card
1. Deactivate a card: Admin → Kartu Pembayaran → Edit → Status: Inactive
2. Try to search for card
3. ✓ Inactive card not shown in results
4. ✓ Cannot use for payment

### 16. Insufficient Stock
1. Try to purchase more items than stock
2. ✓ Error message: "Stok [Product] tidak cukup"
3. ✓ Transaction cancelled
4. ✓ Balance not deducted
5. ✓ Stock not reduced

### 17. Card Not Found
1. Search with invalid/non-existent code
2. ✓ "Kartu tidak ditemukan" message appears

### 18. Empty Cart
1. Try to checkout with empty cart
2. ✓ Error message: "items required"
3. ✓ Cannot proceed to payment

## Performance Tests

### 19. Search Performance
- Search for cards with 50+ cards in system
- ✓ Results appear within 500ms
- ✓ No UI freezing

### 20. Large Transaction History
- Card with 100+ transactions
- ✓ Pagination works
- ✓ Loads in < 1 second
- ✓ Can navigate through pages

## Data Integrity Tests

### 21. Transaction Atomicity
1. Start transaction with card payment
2. Stop server during processing (kill PHP)
3. Restart server
4. ✓ Either complete transaction OR no changes
5. ✓ No orphaned records
6. ✓ Balance and stock consistent

### 22. Transaction History Accuracy
1. Complete 5 transactions with same card
2. Check transaction history
3. ✓ All 5 transactions listed
4. ✓ Balance before/after correct for each
5. ✓ Running total matches current balance

### 23. Multiple Cards
1. Complete transactions with 3 different cards
2. Check each card:
   - **Path:** Admin → Kartu Pembayaran → [Each Card]
3. ✓ Each card has correct balance
4. ✓ Only their own transactions shown
5. ✓ No balance leakage between cards

## UI/UX Tests

### 24. Responsive Design
- Desktop (1920px): All columns visible
- Tablet (768px): Batch columns hidden (tag, method)
- Mobile (375px): Only code, total, action visible

### 25. Mobile Payment Flow
1. On mobile device/browser (375px)
2. Complete full transaction flow
3. ✓ Searchable input works
4. ✓ Modal fits screen
5. ✓ All buttons clickable
6. ✓ No horizontal scroll needed

### 26. Sidebar Navigation
1. Admin user logged in
2. Sidebar should show:
   - Dashboard
   - **Produk**
   - **Kategori**
   - **Kartu Pembayaran** ← New
   - **Laporan**
   - **Kelola User**
   - Transaksi
3. ✓ Click "Kartu Pembayaran" navigates to cards index

## Accessibility Tests

### 27. Keyboard Navigation
1. Use Tab to navigate form
2. ✓ Focus indicator visible
3. ✓ Can submit with Enter
4. ✓ Can close modal with Escape

### 28. Color Contrast
- All text meets WCAG AA standard
- Status badges readable
- ✓ No red/green only reliance (also uses symbols)

## Integration Tests

### 29. Session Persistence
1. Start transaction
2. Search for card
3. Clear session (restart browser)
4. ✓ Either forced back to start OR session restored
5. ✓ No data loss

### 30. Database Consistency
1. Run: `php artisan tinker`
2. Check: `PaymentCard::all()->sum('saldo')`
3. Check: `PaymentCardTransaction::all()->groupBy('payment_card_id')->map->sum('amount')`
4. ✓ Totals match card balances
5. ✓ No negative balances
6. ✓ No orphaned transactions

## Rollback & Recovery

### 31. Migration Rollback
```bash
php artisan migrate:rollback
```
✓ payment_card_to_transaksis migration rolls back
✓ payment_card_transactions migration rolls back
✓ payment_cards migration rolls back
✓ No errors

### 32. Fresh Migration
```bash
php artisan migrate:fresh --seed
```
✓ All migrations run
✓ All seeders run
✓ 5 test cards created
✓ Sample products created
✓ Ready for testing

## Sign-Off Checklist

- [ ] All 32 test scenarios completed
- [ ] No errors in log files
- [ ] No console JavaScript errors
- [ ] Database integrity verified
- [ ] Stock deductions correct
- [ ] Card balance deductions correct
- [ ] Transaction history accurate
- [ ] Mobile responsiveness verified
- [ ] Payment flow end-to-end working
- [ ] Admin sidebar shows payment cards link
- [ ] Barcode data stored correctly
- [ ] Test data (5 cards) seeded successfully

## Quick Test Command Sequence

```bash
# Fresh database
php artisan migrate:fresh --seed

# Check cards created
php artisan tinker
>>> PaymentCard::all()

# Check initial stock
>>> Produk::first()->stok

# Login and test UI manually
# URL: http://localhost:8000/login
# User: admin@example.com
# Pass: admin123

# Test transaction workflow
# 1. Create transaction
# 2. Select payment method: Card
# 3. Search "card_001"
# 4. Confirm payment
# 5. Verify balance reduced
# 6. Verify stock reduced
```

## Troubleshooting

### Card search returns empty
- Check card status is 'active'
- Verify search query >= 2 characters
- Check PaymentCard model relationships
- Run: `PaymentCard::where('status', 'active')->get()`

### Balance not deducting
- Check `deductBalance()` method called
- Verify PaymentCardTransaction created
- Check database transaction integrity
- Run: `PaymentCard::find(1)->transactions`

### Stock not deducting
- Check TransaksiDetail created
- Verify `decrement()` called on Produk
- Check transaction atomicity with DB::beginTransaction()
- Run: `Produk::find(1)->stok`

### Sidebar doesn't show Kartu Pembayaran
- Check user role is 'admin'
- Clear config cache: `php artisan config:cache`
- Verify sidebar.blade.php updated
- Check Auth::user()->role == 'admin' condition

## Performance Benchmarks

Expected times for normal operations:
- Card search (100 cards): < 500ms
- Transaction list load: < 1s
- Payment confirmation: < 500ms
- Balance update: < 100ms
- Stock deduction: < 100ms

---

**Last Updated:** 2026-07-18
**System Version:** v1.0
**Payment Card System:** Active
