# 🎮 Keyboard Shortcuts Guide - POS Payment Flow

## Confirm Payment Page (Konfirmasi Pembayaran)

### Shortcuts:
| Key | Action | Result |
|-----|--------|--------|
| **Enter** | Submit form | Process payment ✓ |
| **Esc** | Cancel/Back | Return to POS create page |

### How to Test:
```
1. Go to: Transaksi → Create → Select Kartu ID → Search Card → Confirm Payment
   Or: Direct URL: /transaksi/confirm-payment (if have active session)

2. Open Browser DevTools:
   Press: F12
   Go to: Console tab

3. Should see message:
   KEYBOARD SHORTCUTS LOADED

4. Test shortcuts:
   - Press Enter → Should process payment
   - Press Esc → Should go back to POS create page
   
5. Watch Console for logs:
   Key: Enter Code: Enter CtrlKey: false
   ENTER PRESSED
   Form found, submitting...
```

---

## Confirmation Page (Pembayaran Berhasil)

### Shortcuts:
| Key | Action | Result |
|-----|--------|--------|
| **Enter** | Complete | Return to transaction list |
| **Ctrl+Enter** | Print Receipt | Open print dialog for struk |

### How to Test:
```
1. After payment confirmation, you see "Pembayaran Berhasil"

2. Open Browser DevTools:
   Press: F12
   Go to: Console tab

3. Should see message:
   CONFIRMATION PAGE KEYBOARD SHORTCUTS LOADED

4. Test shortcuts:
   - Press Enter → Should go back to Daftar Transaksi
   - Press Ctrl+Enter → Should open print window with receipt
   
5. Watch Console for logs:
   Key: Enter Code: Enter Ctrl: false
   ENTER PRESSED - going to transaction list
   
   OR:
   
   Key: Enter Code: Enter Ctrl: true
   CTRL+ENTER PRESSED - printing receipt
   PRINT RECEIPT CALLED
```

---

## Full Workflow (Keyboard-Only)

### Scenario: Complete POS Checkout with Keyboard

```
1. SCAN/INPUT PRODUCTS:
   - Go to: Transaksi → Create (POS Page)
   - Scan barcode or type product name
   - Press Enter → Product auto-selects
   - Type qty if needed
   - Press Enter again → Move to next row
   - Repeat for all products

2. SELECT PAYMENT METHOD:
   - Tab to: 💵 Tunai or 🆔 Kartu ID button
   - Space or Enter to select
   - (Or click if needed)

3. PROCESS PAYMENT:
   - Click: Proses Pembayaran (or keyboard navigation)
   - Page redirects to confirm-payment
   - Press Enter → Process payment
   - (Or press Esc to cancel)

4. CONFIRMATION:
   - See: "Pembayaran Berhasil" message
   - Press Enter → Back to transaction list
   - (Or press Ctrl+Enter → Print receipt before going back)

5. REPEAT FOR NEXT CUSTOMER!
```

---

## Debugging

### If Console Shows Nothing:

1. **Hard Refresh (Clear Cache):**
   - Windows: Ctrl+Shift+F5 or Ctrl+F5
   - Mac: Cmd+Shift+R or Cmd+Option+R
   - Chrome: Ctrl+Shift+Delete (clear cache in settings)

2. **Check if message appears:**
   - Refresh page
   - Open Console (F12)
   - Look for: "KEYBOARD SHORTCUTS LOADED"
   - If NOT there, check browser console for errors

3. **Test if keyboard works:**
   - In console, type: `document.addEventListener`
   - This checks if event listeners can attach

4. **Test if form exists:**
   - In console, type: `document.getElementById('formKonfirmasi')`
   - Should show: `<form id="formKonfirmasi">...</form>`
   - If shows `null`, form element missing

### Common Issues:

| Issue | Solution |
|-------|----------|
| Console shows nothing | Hard refresh (Ctrl+Shift+F5) or clear browser cache |
| Message doesn't appear | Check if page URL is correct (confirm-payment or confirmation) |
| Keys don't work in console | Keys intercepted by page, try pressing in the page content area |
| Form doesn't submit | Check if formKonfirmasi exists: `document.getElementById('formKonfirmasi')` |
| Print doesn't open | May be blocked by browser popup blocker - check notification bar |

---

## Expected Console Output

### Confirm Payment - When Press Enter:
```
KEYBOARD SHORTCUTS LOADED
setupKeyboardShortcuts() called
Key: Enter Code: Enter
ENTER PRESSED
Form found, submitting...
```

### Confirm Payment - When Press Esc:
```
KEYBOARD SHORTCUTS LOADED
setupKeyboardShortcuts() called
Key: Escape Code: Escape
ESCAPE PRESSED - going back
```

### Confirmation Page - When Press Enter:
```
CONFIRMATION PAGE KEYBOARD SHORTCUTS LOADED
setupKeyboardShortcuts() called
Key: Enter Code: Enter Ctrl: false
ENTER PRESSED - going to transaction list
```

### Confirmation Page - When Press Ctrl+Enter:
```
CONFIRMATION PAGE KEYBOARD SHORTCUTS LOADED
setupKeyboardShortcuts() called
Key: Enter Code: Enter Ctrl: true
CTRL+ENTER PRESSED - printing receipt
PRINT RECEIPT CALLED
```

---

## Tips for Power Users

1. **Use Tab Key:** Navigate between buttons
2. **Use Space:** Activate buttons when focused
3. **Use Esc:** Quick escape from any confirmation page
4. **Use Ctrl+Enter:** Quick print after payment
5. **Barcode Scanner:** Works with Enter key on POS page

---

## Browser Support

✓ Chrome / Edge / Firefox / Safari (all modern versions)
✓ Works on Windows, Mac, Linux
✓ Mobile: Keyboard shortcuts work on external keyboards

---

Generated: 2026-07-18
Last Updated: Keyboard shortcuts with defer attribute
