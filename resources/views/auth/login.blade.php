<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Coole-Bill POS</title>

    @vite('resources/css/app.css')
</head>
<body class="bg-slate-100">

<div class="min-h-screen flex">

    <!-- KIRI -->
    <div class="hidden lg:flex w-1/2 bg-gradient-to-br from-orange-600 to-amber-600 items-center justify-center">

        <div class="text-center text-white px-10">

            <div class="text-7xl mb-8">
                🖩
            </div>

            <h1 class="text-5xl font-bold mb-5">
                COOLE-BILL
            </h1>

            <p class="text-xl text-blue-100">
                Smart System of Store Manage
            </p>

            <div class="mt-12 space-y-3 text-blue-100">

                <p>✔ Kelola Produk</p>

                <p>✔ Transaksi Cepat</p>

                <p>✔ Dashboard Penjualan</p>

                <p>✔ Laporan Harian</p>

            </div>

        </div>

    </div>

    <!-- KANAN -->
    <div class="flex-1 flex items-center justify-center p-6 bg-gradient-to-br from-orange-700 to-amber-600">

        <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl p-10">

            <div class="text-center mb-8">

                <div class="text-5xl mb-3">
                    🔔
                </div>

                <h2 class="text-3xl font-bold text-slate-800">
                    Selamat Datang
                </h2>

                <p class="text-slate-500 mt-2">
                    Login untuk melanjutkan
                </p>

            </div>

            <form method="POST" action="{{ route('login') }}">

                @csrf

                <!-- EMAIL -->

                <div class="mb-5">

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Username
                    </label>

                    <input
                        type="text"
                        name="username"
                        value="{{ old('username') }}"
                        required
                        autofocus

                        class="w-full rounded-xl border border-slate-300 px-4 py-3
                        focus:outline-none focus:ring-2 focus:ring-blue-500
                        focus:border-blue-500 transition"
                    >

                    @error('username')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <!-- PASSWORD -->

                <div class="mb-5">

                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        required

                        class="w-full rounded-xl border border-slate-300 px-4 py-3
                        focus:outline-none focus:ring-2 focus:ring-blue-500
                        focus:border-blue-500 transition"
                    >

                    @error('password')
                        <p class="text-red-500 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

                <!-- REMEMBER -->

                <div class="flex items-center justify-between mb-8">

                    <label class="flex items-center gap-2">

                        <input
                            type="checkbox"
                            name="remember"
                            class="rounded border-gray-300 text-blue-600"
                        >

                        <span class="text-sm text-slate-600">
                            Remember Me
                        </span>

                    </label>

                </div>

                <!-- BUTTON -->

                <button
                    type="submit"

                    class="w-full bg-blue-600 hover:bg-blue-700
                    text-white font-semibold py-3 rounded-xl
                    transition duration-300 shadow-lg hover:shadow-xl">

                    Login

                </button>

            </form>

            <div class="mt-8 text-center text-sm text-slate-400">

                © {{ date('Y') }} Coole-Bill POS

            </div>

        </div>

    </div>

</div>

</body>
</html>