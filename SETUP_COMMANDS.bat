@echo off
echo ============================================
echo   CoolE-Bill POS - Database Setup
echo ============================================
echo.

echo [1/3] Menghapus database lama dan membuat tabel baru...
php artisan migrate:fresh

echo.
echo [2/3] Mengisi database dengan data dummy...
php artisan db:seed

echo.
echo [3/3] Menampilkan informasi database...
php artisan db:show

echo.
echo ============================================
echo   Setup Database Selesai!
echo ============================================
echo.
echo Login Credentials:
echo   Admin: username = admin, password = admin123
echo   Kasir: username = kasir, password = kasir123
echo.
echo Tekan tombol apapun untuk keluar...
pause >nul
