<aside class="w-56 h-screen bg-gradient-to-b from-orange-600 to-orange-500 shadow-lg flex flex-col">

    <!-- Logo Section -->
    <div class="px-4 py-4 border-b border-orange-700/30 flex-shrink-0">

        <div class="flex flex-col gap-1.5">
            <div class="flex items-center gap-1">
                <!-- COOL: BG Hitam, Text Putih -->
                <div class="px-2.5 py-1 rounded flex items-center justify-center" style="background-color: #000000 !important;">
                    <span class="font-black text-xs" style="color: #FFFFFF !important;">COOL</span>
                </div>
                <!-- E-BILL: BG Putih, Text Orange -->
                <div class="px-2.5 py-1 rounded flex items-center justify-center" style="background-color: #FFFFFF !important;">
                    <span class="font-black text-xs" style="color: #EA580C !important;">E-BILL</span>
                </div>
            </div>
            <p class="text-xs font-medium" style="color: rgb(254 215 170) !important;">Smart POS</p>
        </div>

    </div>

    <!-- Navigation -->
    <nav class="px-3 py-4 space-y-1 flex-1 overflow-y-auto">

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
           class="sidebar-link flex items-center gap-2.5 px-3 py-2.5 text-sm font-medium rounded-lg hover:bg-white/10 backdrop-blur-sm transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-white shadow-lg' : '' }}"
           style="color: {{ request()->routeIs('dashboard') ? '#EA580C' : 'rgba(255, 255, 255, 0.9)' }} !important;">
            <span class="w-1 h-5 rounded-full transition-all duration-200" style="background-color: {{ request()->routeIs('dashboard') ? '#EA580C' : 'rgba(255, 255, 255, 0.7)' }} !important;"></span>
            <span class="font-semibold">Dashboard</span>
        </a>

        @if(Auth::user()->role == 'admin')

            <!-- Admin Section -->
            <div class="mt-4 mb-2 px-3">
                <h3 class="text-xs font-semibold uppercase tracking-wider" style="color: rgb(254 215 170) !important;">Admin</h3>
            </div>

            <a href="{{ route('produk.index') }}"
               class="sidebar-link flex items-center gap-2.5 px-3 py-2.5 text-sm font-medium rounded-lg hover:bg-white/10 backdrop-blur-sm transition-all duration-200 {{ request()->routeIs('produk.*') ? 'bg-white shadow-lg' : '' }}"
               style="color: {{ request()->routeIs('produk.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.9)' }} !important;">
                <span class="w-1 h-5 rounded-full transition-all duration-200" style="background-color: {{ request()->routeIs('produk.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.7)' }} !important;"></span>
                <span class="font-semibold">Produk</span>
            </a>

            <a href="{{ route('kategori.index') }}"
               class="sidebar-link flex items-center gap-2.5 px-3 py-2.5 text-sm font-medium rounded-lg hover:bg-white/10 backdrop-blur-sm transition-all duration-200 {{ request()->routeIs('kategori.*') ? 'bg-white shadow-lg' : '' }}"
               style="color: {{ request()->routeIs('kategori.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.9)' }} !important;">
                <span class="w-1 h-5 rounded-full transition-all duration-200" style="background-color: {{ request()->routeIs('kategori.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.7)' }} !important;"></span>
                <span class="font-semibold">Kategori</span>
            </a>

            <a href="{{ route('payment-cards.index') }}"
               class="sidebar-link flex items-center gap-2.5 px-3 py-2.5 text-sm font-medium rounded-lg hover:bg-white/10 backdrop-blur-sm transition-all duration-200 {{ request()->routeIs('payment-cards.*') ? 'bg-white shadow-lg' : '' }}"
               style="color: {{ request()->routeIs('payment-cards.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.9)' }} !important;">
                <span class="w-1 h-5 rounded-full transition-all duration-200" style="background-color: {{ request()->routeIs('payment-cards.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.7)' }} !important;"></span>
                <span class="font-semibold text-xs">Kartu Bayar</span>
            </a>

            <a href="{{ route('laporan.index') }}"
               class="sidebar-link flex items-center gap-2.5 px-3 py-2.5 text-sm font-medium rounded-lg hover:bg-white/10 backdrop-blur-sm transition-all duration-200 {{ request()->routeIs('laporan.*') ? 'bg-white shadow-lg' : '' }}"
               style="color: {{ request()->routeIs('laporan.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.9)' }} !important;">
                <span class="w-1 h-5 rounded-full transition-all duration-200" style="background-color: {{ request()->routeIs('laporan.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.7)' }} !important;"></span>
                <span class="font-semibold">Laporan</span>
            </a>

            <a href="{{ route('users.index') }}"
               class="sidebar-link flex items-center gap-2.5 px-3 py-2.5 text-sm font-medium rounded-lg hover:bg-white/10 backdrop-blur-sm transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-white shadow-lg' : '' }}"
               style="color: {{ request()->routeIs('users.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.9)' }} !important;">
                <span class="w-1 h-5 rounded-full transition-all duration-200" style="background-color: {{ request()->routeIs('users.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.7)' }} !important;"></span>
                <span class="font-semibold text-xs">Kelola User</span>
            </a>

        @endif

        <!-- Transactions -->
        <a href="{{ route('transaksi.index') }}"
           class="sidebar-link flex items-center gap-2.5 px-3 py-2.5 text-sm font-medium rounded-lg hover:bg-white/10 backdrop-blur-sm transition-all duration-200 {{ request()->routeIs('transaksi.*') ? 'bg-white shadow-lg' : '' }}"
           style="color: {{ request()->routeIs('transaksi.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.9)' }} !important;">
            <span class="w-1 h-5 rounded-full transition-all duration-200" style="background-color: {{ request()->routeIs('transaksi.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.7)' }} !important;"></span>
            <span class="font-semibold">Transaksi</span>
        </a>

    </nav>

    <!-- Footer Section -->
    <div class="px-3 py-3 border-t flex-shrink-0 space-y-1.5" style="border-color: rgba(194, 65, 12, 0.3) !important;">

        <!-- Back to Home Button -->
        <a href="{{ route('home') }}"
           class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-medium rounded-lg hover:bg-white/10 backdrop-blur-sm transition-all duration-200" 
           style="color: rgba(255, 255, 255, 0.9) !important;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Ke Beranda</span>
        </a>

        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-medium rounded-lg hover:bg-red-600 hover:text-white backdrop-blur-sm transition-all duration-200" 
                style="color: rgba(255, 255, 255, 0.9) !important;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span>Logout</span>
            </button>

        </form>

    </div>

</aside>