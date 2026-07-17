<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Coole-Bill POS</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-slate-50">

<!-- Navbar -->
<nav class="bg-white shadow-sm sticky top-0 z-50">

    <div class="max-w-7xl mx-auto flex justify-between items-center py-5 px-8">

        <h1 class="text-3xl font-extrabold text-blue-600">
            COOLE-BILL
        </h1>

        <div class="flex items-center gap-8">

            <a href="#fitur" class="hover:text-blue-600">
                Fitur
            </a>

            <a href="#tentang" class="hover:text-blue-600">
                Tentang
            </a>

            <a href="{{ route('login') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl transition">

                Login

            </a>

        </div>

    </div>

</nav>

<!-- Hero -->
<section class="max-w-7xl mx-auto px-8 py-24">

    <div class="grid lg:grid-cols-2 gap-14 items-center">

        <div>

            <h1 class="text-6xl font-black leading-tight text-slate-800">

                Sistem Kasir Modern
                untuk Bisnis Anda

            </h1>

            <p class="text-slate-600 text-xl mt-8">

                Kelola produk, transaksi, stok, dan laporan
                dalam satu aplikasi yang cepat dan mudah digunakan.

            </p>

            <div class="flex gap-5 mt-10">

                <a href="{{ route('login') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-xl">

                    Mulai Sekarang

                </a>

                <a href="#fitur"
                    class="border border-blue-600 text-blue-600 px-8 py-4 rounded-xl">

                    Lihat Fitur

                </a>

            </div>

        </div>

        <div>

            <img
            src="/public/images/hero.png"
            class="rounded-3xl shadow-2xl">

        </div>

    </div>

</section>

<!-- Fitur -->

<section
id="fitur"
class="bg-white py-20">

<div class="max-w-7xl mx-auto px-8">

<h2 class="text-4xl font-bold text-center mb-14">

Fitur Unggulan

</h2>

<div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">

<div class="bg-slate-50 rounded-3xl p-8 shadow">

<h3 class="text-xl font-bold mb-3">

📦 Produk

</h3>

<p>

Kelola produk, stok,
harga dan foto.

</p>

</div>

<div class="bg-slate-50 rounded-3xl p-8 shadow">

<h3 class="text-xl font-bold mb-3">

🛒 Transaksi

</h3>

<p>

Transaksi cepat
dengan sistem kasir.

</p>

</div>

<div class="bg-slate-50 rounded-3xl p-8 shadow">

<h3 class="text-xl font-bold mb-3">

📊 Laporan

</h3>

<p>

Laporan harian
dan bulanan.

</p>

</div>

<div class="bg-slate-50 rounded-3xl p-8 shadow">

<h3 class="text-xl font-bold mb-3">

📈 Dashboard

</h3>

<p>

Pantau penjualan
secara real time.

</p>

</div>

</div>

</div>

</section>

<!-- Tentang -->

<section
id="tentang"
class="py-24">

<div class="max-w-5xl mx-auto text-center px-8">

<h2 class="text-4xl font-bold mb-8">

Tentang Coole-Bill

</h2>

<p class="text-lg text-slate-600">

Coole-Bill POS adalah aplikasi kasir berbasis Laravel
yang membantu mengelola transaksi,
produk, stok, dan laporan penjualan
dengan tampilan modern dan mudah digunakan.

</p>

</div>

</section>

<!-- Footer -->

<footer class="bg-slate-900 text-white py-8">

<div class="text-center">

<h2 class="text-2xl font-bold">

COOLE-BILL POS

</h2>

<p class="mt-3 text-slate-400">

© {{ date('Y') }} All Rights Reserved.

</p>

</div>

</footer>

</body>
</html>