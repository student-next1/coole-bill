<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | Coole-Bill POS</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 antialiased">

<div class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">
    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-slate-800 mb-2">Daftar Akun</h1>
            <p class="text-slate-500">Buat akun baru untuk menggunakan Coole-Bill</p>
        </div>
        
        <!-- Placeholder untuk form registrasi -->
        <div class="space-y-6">
            <div class="text-center py-12">
                <p class="text-slate-400 text-sm">Form registrasi akan diisi kemudian</p>
            </div>
        </div>

        <!-- Link ke halaman login -->
        <div class="mt-8 pt-6 border-t border-slate-200 text-center">
            <p class="text-sm text-slate-600">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-semibold text-orange-600 hover:text-orange-700 transition-colors">
                    Masuk di sini
                </a>
            </p>
        </div>
    </div>
</div>

</body>
</html>
