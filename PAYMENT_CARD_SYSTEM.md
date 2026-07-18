# Cool E-Bill Payment Card System - Complete Documentation

## System Overview

Custom prepaid card payment system integrated into the POS. Customers can:
- Create prepaid payment cards with unique codes
- Use barcode/username search to pay for transactions
- View transaction history and balance
- Topup card balance
- Manage card status and information

## Architecture

### Models
- **PaymentCard**: Stores card information, balance, status
- **PaymentCardTransaction**: Audit log of all balance changes
- **Transaksi**: Enhanced with `payment_card_id` for card payments

### Controllers
- **PaymentCardController**: CRUD operations, search, topup, transaction history

### Routes
All under `/payment-cards` namespace:
- `GET /` - List all cards
- `GET /create` - Create form
- `POST /` - Store new card
- `GET /{id}` - Card detail
- `GET /{id}/edit` - Edit form
- `PUT /{id}` - Update card
- `DELETE /{id}` - Delete card
- `GET /{id}/topup` - Topup form
- `POST /{id}/topup` - Process topup
- `GET /{id}/transactions` - Transaction history
- `GET /search/card` - Search cards (AJAX)

Transaction flow routes:
- `POST /transaksi/select-payment` - Choose payment method
- `GET /transaksi/select-card?method=card` - Card search page
- `GET /transaksi/find-card?q=...` - Search AJAX
- `POST /transaksi/store` - Process payment

## Database Schema

### payment_cards table
```sql
CREATE TABLE payment_cards (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    card_code VARCHAR(255) UNIQUE NOT NULL,      -- CARD-YYYYMMDDHHiiss-RRRRR
    barcode_data VARCHAR(255) NOT NULL,          -- QR/barcode data
    username VARCHAR(255) UNIQUE NULLABLE,       -- Optional username
    holder_name VARCHAR(255) NOT NULL,           -- Card owner name
    saldo BIGINT NOT NULL DEFAULT 0,             -- Current balance
    status ENUM('active','inactive','blocked'),  -- Card status
    notes TEXT NULLABLE,                         -- Internal notes
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### payment_card_transactions table
```sql
CREATE TABLE payment_card_transactions (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    payment_card_id BIGINT NOT NULL FK,          -- Reference to card
    transaksi_id BIGINT NULLABLE FK,             -- Reference to POS transaction
    type ENUM('purchase','topup','refund','adjustment'),
    amount BIGINT NOT NULL,                      -- Transaction amount
    saldo_before BIGINT NOT NULL,                -- Balance before
    saldo_after BIGINT NOT NULL,                 -- Balance after
    description VARCHAR(255) NULLABLE,           -- Transaction details
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

### transaksis table (modified)
```sql
ALTER TABLE transaksis ADD COLUMN (
    payment_card_id BIGINT NULLABLE FK
);
```

## Key Features

### 1. Card Code Generation
- Automatic unique code: `CARD-YYYYMMDDHHiiss-RRRRR`
- Timestamp-based: Year, Month, Day, Hour, Minute, Second, +5 random digits
- Prevents duplicates across system

### 2. Balance Management
Methods in PaymentCard model:
- `hasEnoughBalance($amount)`: Check if card active and has sufficient balance
- `deductBalance($amount, $transaksiId, $description)`: Deduct and create transaction record
- `addBalance($amount, $description)`: Topup and create transaction record

### 3. Search Methods
- By card code (exact or partial)
- By username (if set)
- By holder name (partial match)
- Returns only active cards
- AJAX-based with 300ms debounce

### 4. Transaction Atomicity
Uses `DB::beginTransaction()` to ensure:
- If payment succeeds → stock decrement + card deduction succeed together
- If payment fails → both rollback, no partial changes
- All operations logged in PaymentCardTransaction table

### 5. Audit Trail
Every balance change creates PaymentCardTransaction record with:
- Type: purchase, topup, refund, adjustment
- Amount: absolute value
- Saldo before/after: for verification
- Timestamp: for chronological tracking
- Description: human-readable reason

## User Flows

### Admin: Create Payment Card
```
Admin Dashboard
  ↓
Sidebar: Kartu Pembayaran
  ↓
Click: Tambah Kartu Baru
  ↓
Form: holder_name, username, initial_saldo, status
  ↓
Submit → Store in DB with auto-generated card_code
  ↓
Redirect to card detail page
```

### Admin: Manage Card
```
Kartu Pembayaran → [Select Card] → Detail
  ↓ Options:
  - Edit: Change name/username/status
  - Topup: Add balance
  - Riwayat: View all transactions
  - Print: Print card design
  - Delete: Remove card
```

### Customer: Purchase with Card
```
Dashboard → Buat Transaksi
  ↓
Add products → Click "Proses Pembayaran"
  ↓
Select: "Kartu Pembayaran" method
  ↓
Search card by code/username/name
  ↓
Click card → See card detail + order summary
  ↓
Click "Konfirmasi & Proses" if balance sufficient
  ↓
Transaction processed:
  - Create Transaksi record with payment_card_id
  - Deduct product stock
  - Deduct card balance
  - Create PaymentCardTransaction audit record
  ↓
Success → Redirect to transaction list
```

### View Transaction History
```
Transaksi List
  ↓
See columns: Code, Cashier, Total, Method, Card Holder, Card Code, Time
  ↓
Click "Detail" on card transaction
  ↓
Modal shows: Card holder name, balance deduction details
```

## API Responses

### Search Cards (AJAX)
```json
GET /transaksi/find-card?q=card_001

Response (200):
[
  {
    "id": 1,
    "card_code": "CARD-20260718091753-65493",
    "username": "card_001",
    "holder_name": "Andi Wijaya",
    "saldo": 1000000
  },
  ...
]

Error (400):
{ "error": "Masukkan minimal 2 karakter" }
```

## Validation Rules

### Create/Edit Card
- `holder_name`: required, string, max 255
- `username`: unique, string, max 255, nullable
- `saldo`: required, numeric, min 0 (create only)
- `status`: required, in (active, inactive, blocked)
- `notes`: nullable, string

### Payment Processing
- `items`: required, array, min 1 item
- `payment_card_id`: exists in payment_cards table
- `payment_card.status`: must be 'active'
- `payment_card.saldo`: >= transaction total
- `product.stok`: >= requested quantity

## Error Handling

### Insufficient Balance
- Check happens at confirm payment stage
- User cannot select card if balance < total
- Transaction rollback if balance check fails during processing

### Inactive/Blocked Card
- Card not returned in search results
- Cannot use in payment even if found in database

### Insufficient Stock
- Validation before deduction
- Returns error: "Stok [Product] tidak cukup"
- Transaction cancelled, card balance unchanged

### Database Errors
- All operations wrapped in DB::beginTransaction()
- Any error triggers rollback
- Returns user-friendly error message

## Testing & Deployment

### Pre-seeded Test Data
Run `php artisan migrate:fresh --seed`:
- Creates 5 test payment cards
- Initial balance: Rp 250,000 - Rp 2,000,000
- Usernames: card_001 through card_005
- All active and ready for transactions

### Testing Guide
See `PAYMENT_CARD_TESTING.md` for:
- 32 comprehensive test scenarios
- Each scenario with steps and expected results
- Error handling tests
- Performance benchmarks
- Data integrity checks

### Quick Test
```bash
# Start fresh
php artisan migrate:fresh --seed

# Verify setup
php artisan tinker
>>> PaymentCard::count()        # Should be 5
>>> PaymentCard::sum('saldo')   # Total balance
>>> Produk::count()             # Should be 12
>>> User::count()               # Should be 2

# Login and test UI
# URL: http://localhost:8000/login
# Admin: admin@example.com / admin123
```

## Performance Considerations

### Query Optimization
- Loaded relationships: `with('user', 'details.produk', 'paymentCard')`
- Indexed fields: card_code (UNIQUE), username (UNIQUE)
- Pagination: 10 items per page default

### Frontend Optimization
- AJAX search with 300ms debounce (reduces API calls)
- Modal confirmation (no page reload)
- Lazy load: transaction history paginated

### Database Optimization
- Foreign key constraints enforce data integrity
- Cascading deletes handled via model relationships
- Transaction logs prevent balance drift

## Security Measures

### Access Control
- All payment routes require `middleware('auth')`
- Payment card management restricted to admin role
- Sidebar link only visible to admin

### Data Validation
- All inputs validated server-side (not client-only)
- SQL injection prevented via parameterized queries (Eloquent)
- XSS prevention via Blade escaping

### Balance Integrity
- Audit trail created for every transaction
- Can verify balance = sum of all transactions
- Double-entry accounting via saldo_before/saldo_after

### Transaction Safety
- Atomic operations: stock + balance change together or not at all
- No race conditions: database transactions serialize operations
- Rollback on any error: consistent state maintained

## Future Enhancements

### Potential Features
1. Card PIN/Authentication for security
2. Daily/monthly spending limits
3. Automatic card deactivation after period
4. Multi-currency support
5. Card PIN/OTP for large transactions
6. Real-time balance synchronization
7. Card transfer between users
8. Promotional topup bonuses
9. Card expiry dates
10. Integration with physical card printing

### Data Extensions
- QR code rendering (currently SVG placeholder)
- NFC/RFID card support
- Multi-language support for card printing
- Advanced reporting/analytics
- Card statement export (PDF)

## Troubleshooting

### Issue: Card search returns empty
**Solution:**
- Verify card status is 'active'
- Check search query >= 2 characters
- Confirm card exists: `PaymentCard::all()`

### Issue: Balance not deducting
**Solution:**
- Check PaymentCardTransaction records created
- Verify `deductBalance()` called correctly
- Run: `PaymentCard::find($id)->transactions`

### Issue: Stock not deducting
**Solution:**
- Check TransaksiDetail created
- Verify `decrement('stok', $qty)` executed
- Ensure no transaction rollback occurred

### Issue: Sidebar doesn't show "Kartu Pembayaran"
**Solution:**
- Verify user role is 'admin'
- Clear cache: `php artisan config:cache`
- Check sidebar.blade.php has navigation link
- Verify Auth::user()->role == 'admin' condition

## Related Documentation

- `PAYMENT_CARD_TESTING.md` - Comprehensive testing guide (32 scenarios)
- `DATABASE_SETUP.md` - Database configuration and setup
- `FEATURES.md` - Complete system features list
- Migration files in `database/migrations/`

## System Statistics

**As of 2026-07-18:**
- Database tables: 3 (payment_cards, payment_card_transactions, transaksis modified)
- Models: 2 (PaymentCard, PaymentCardTransaction)
- Controllers: 1 (PaymentCardController)
- Views: 6 (index, create, edit, show, topup, transactions)
- Routes: 11 payment card routes + 6 transaction flow routes
- Seeders: 1 (PaymentCardSeeder with 5 cards)

## Support & Maintenance

For issues or questions:
1. Check `PAYMENT_CARD_TESTING.md` for similar scenarios
2. Review database schema for data structure
3. Check PaymentCard model methods for implementation details
4. Review TransaksiController for payment flow logic

---

**Version:** 1.0
**Status:** Complete & Ready for Production
**Last Updated:** 2026-07-18
**Test Coverage:** 32 comprehensive test scenarios
**Ready for Testing:** Yes
