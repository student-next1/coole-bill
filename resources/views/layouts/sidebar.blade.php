<aside class="w-64 h-screen bg-gradient-to-b from-orange-600 to-orange-500 shadow-lg flex flex-col">

    <!-- Logo Section -->
    <div class="px-6 py-6 border-b border-orange-700/30 flex-shrink-0">

        <div class="flex flex-col gap-2">
            <div class="flex items-center gap-1">
                <div class="px-3 py-1.5 bg-black rounded flex items-center justify-center">
                    <span class="text-white font-black text-sm">COOL</span>
                </div>
                <div class="px-3 py-1.5 bg-white rounded flex items-center justify-center">
                    <span class="text-orange-600 font-black text-sm">E-BILL</span>
                </div>
            </div>
            <p class="text-xs text-orange-100 font-medium">Smart POS System</p>
        </div>

    </div>

    <!-- Navigation -->
    <nav class="px-4 py-6 space-y-1 flex-1 overflow-y-auto">

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 text-white font-medium rounded-lg hover:bg-white/10 backdrop-blur-sm transition-all duration-200">
            <span class="w-1 h-6 bg-white rounded-full"></span>
            <span>Dashboard</span>
        </a>

        @if(Auth::user()->role == 'admin')

            <!-- Admin Section -->
            <div class="mt-6 mb-3 px-4">
                <h3 class="text-xs font-semibold text-orange-200 uppercase tracking-wider">Admin</h3>
            </div>

            <a href="{{ route('produk.index') }}"
               class="flex items-center gap-3 px-4 py-3 text-white/90 font-medium rounded-lg hover:bg-white/10 hover:text-white backdrop-blur-sm transition-all duration-200">
                <span class="w-1 h-6 bg-white/70 rounded-full"></span>
                <span>Produk</span>
            </a>

            <a href="{{ route('kategori.index') }}"
               class="flex items-center gap-3 px-4 py-3 text-white/90 font-medium rounded-lg hover:bg-white/10 hover:text-white backdrop-blur-sm transition-all duration-200">
                <span class="w-1 h-6 bg-white/70 rounded-full"></span>
                <span>Kategori</span>
            </a>

            <a href="{{ route('payment-cards.index') }}"
               class="flex items-center gap-3 px-4 py-3 text-white/90 font-medium rounded-lg hover:bg-white/10 hover:text-white backdrop-blur-sm transition-all duration-200">
                <span class="w-1 h-6 bg-white/70 rounded-full"></span>
                <span>Kartu Pembayaran</span>
            </a>

            <a href="{{ route('laporan.index') }}"
               class="flex items-center gap-3 px-4 py-3 text-white/90 font-medium rounded-lg hover:bg-white/10 hover:text-white backdrop-blur-sm transition-all duration-200">
                <span class="w-1 h-6 bg-white/70 rounded-full"></span>
                <span>Laporan</span>
            </a>

            <a href="{{ route('users.index') }}"
               class="flex items-center gap-3 px-4 py-3 text-white/90 font-medium rounded-lg hover:bg-white/10 hover:text-white backdrop-blur-sm transition-all duration-200">
                <span class="w-1 h-6 bg-white/70 rounded-full"></span>
                <span>Kelola User</span>
            </a>

        @endif

        <!-- Transactions -->
        <a href="{{ route('transaksi.index') }}"
           class="flex items-center gap-3 px-4 py-3 text-white/90 font-medium rounded-lg hover:bg-white/10 hover:text-white backdrop-blur-sm transition-all duration-200">
            <span class="w-1 h-6 bg-white/70 rounded-full"></span>
            <span>Transaksi</span>
        </a>

    </nav>

    <!-- Logout Section -->
    <div class="px-4 py-4 border-t border-orange-700/30 flex-shrink-0">

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                class="w-full flex items-center gap-3 px-4 py-3 text-white/90 font-medium rounded-lg hover:bg-red-600 hover:text-white backdrop-blur-sm transition-all duration-200">
                <span class="w-1 h-6 bg-white/70 rounded-full"></span>
                <span>Logout</span>
            </button>

        </form>

    </div>

</aside>