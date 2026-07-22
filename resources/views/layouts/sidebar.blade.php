<aside class="w-64 h-screen bg-gradient-to-b from-orange-600 to-orange-500 shadow-lg flex flex-col">

    <!-- Logo Section -->
    <div class="px-6 py-6 border-b border-orange-700/30 flex-shrink-0">

        <div class="flex flex-col gap-2">
            <div class="flex items-center gap-1">
                <!-- COOL: BG Hitam, Text Putih -->
                <div class="px-3 py-1.5 rounded flex items-center justify-center" style="background-color: #000000 !important;">
                    <span class="font-black text-sm" style="color: #FFFFFF !important;">COOL</span>
                </div>
                <!-- E-BILL: BG Putih, Text Orange -->
                <div class="px-3 py-1.5 rounded flex items-center justify-center" style="background-color: #FFFFFF !important;">
                    <span class="font-black text-sm" style="color: #EA580C !important;">E-BILL</span>
                </div>
            </div>
            <p class="text-xs font-medium" style="color: rgb(254 215 170) !important;">Smart POS System</p>
        </div>

    </div>

    <!-- Navigation -->
    <nav class="px-4 py-6 space-y-1 flex-1 overflow-y-auto">

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
           class="sidebar-link flex items-center gap-3 px-4 py-3 font-medium rounded-lg hover:bg-white/10 backdrop-blur-sm transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-white shadow-lg' : '' }}"
           style="color: {{ request()->routeIs('dashboard') ? '#EA580C' : 'rgba(255, 255, 255, 0.9)' }} !important;">
            <span class="w-1 h-6 rounded-full transition-all duration-200" style="background-color: {{ request()->routeIs('dashboard') ? '#EA580C' : 'rgba(255, 255, 255, 0.7)' }} !important; width: {{ request()->routeIs('dashboard') ? '4px' : '4px' }};"></span>
            <span class="font-semibold">Dashboard</span>
        </a>

        @if(Auth::user()->role == 'admin')

            <!-- Admin Section -->
            <div class="mt-6 mb-3 px-4">
                <h3 class="text-xs font-semibold uppercase tracking-wider" style="color: rgb(254 215 170) !important;">Admin</h3>
            </div>

            <a href="{{ route('produk.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-3 font-medium rounded-lg hover:bg-white/10 backdrop-blur-sm transition-all duration-200 {{ request()->routeIs('produk.*') ? 'bg-white shadow-lg' : '' }}"
               style="color: {{ request()->routeIs('produk.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.9)' }} !important;">
                <span class="w-1 h-6 rounded-full transition-all duration-200" style="background-color: {{ request()->routeIs('produk.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.7)' }} !important; width: {{ request()->routeIs('produk.*') ? '4px' : '4px' }};"></span>
                <span class="font-semibold">Produk</span>
            </a>

            <a href="{{ route('kategori.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-3 font-medium rounded-lg hover:bg-white/10 backdrop-blur-sm transition-all duration-200 {{ request()->routeIs('kategori.*') ? 'bg-white shadow-lg' : '' }}"
               style="color: {{ request()->routeIs('kategori.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.9)' }} !important;">
                <span class="w-1 h-6 rounded-full transition-all duration-200" style="background-color: {{ request()->routeIs('kategori.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.7)' }} !important; width: {{ request()->routeIs('kategori.*') ? '4px' : '4px' }};"></span>
                <span class="font-semibold">Kategori</span>
            </a>

            <a href="{{ route('payment-cards.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-3 font-medium rounded-lg hover:bg-white/10 backdrop-blur-sm transition-all duration-200 {{ request()->routeIs('payment-cards.*') ? 'bg-white shadow-lg' : '' }}"
               style="color: {{ request()->routeIs('payment-cards.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.9)' }} !important;">
                <span class="w-1 h-6 rounded-full transition-all duration-200" style="background-color: {{ request()->routeIs('payment-cards.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.7)' }} !important; width: {{ request()->routeIs('payment-cards.*') ? '4px' : '4px' }};"></span>
                <span class="font-semibold">Kartu Pembayaran</span>
            </a>

            <a href="{{ route('laporan.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-3 font-medium rounded-lg hover:bg-white/10 backdrop-blur-sm transition-all duration-200 {{ request()->routeIs('laporan.*') ? 'bg-white shadow-lg' : '' }}"
               style="color: {{ request()->routeIs('laporan.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.9)' }} !important;">
                <span class="w-1 h-6 rounded-full transition-all duration-200" style="background-color: {{ request()->routeIs('laporan.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.7)' }} !important; width: {{ request()->routeIs('laporan.*') ? '4px' : '4px' }};"></span>
                <span class="font-semibold">Laporan</span>
            </a>

            <a href="{{ route('users.index') }}"
               class="sidebar-link flex items-center gap-3 px-4 py-3 font-medium rounded-lg hover:bg-white/10 backdrop-blur-sm transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-white shadow-lg' : '' }}"
               style="color: {{ request()->routeIs('users.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.9)' }} !important;">
                <span class="w-1 h-6 rounded-full transition-all duration-200" style="background-color: {{ request()->routeIs('users.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.7)' }} !important; width: {{ request()->routeIs('users.*') ? '4px' : '4px' }};"></span>
                <span class="font-semibold">Kelola User</span>
            </a>

        @endif

        <!-- Transactions -->
        <a href="{{ route('transaksi.index') }}"
           class="sidebar-link flex items-center gap-3 px-4 py-3 font-medium rounded-lg hover:bg-white/10 backdrop-blur-sm transition-all duration-200 {{ request()->routeIs('transaksi.*') ? 'bg-white shadow-lg' : '' }}"
           style="color: {{ request()->routeIs('transaksi.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.9)' }} !important;">
            <span class="w-1 h-6 rounded-full transition-all duration-200" style="background-color: {{ request()->routeIs('transaksi.*') ? '#EA580C' : 'rgba(255, 255, 255, 0.7)' }} !important; width: {{ request()->routeIs('transaksi.*') ? '4px' : '4px' }};"></span>
            <span class="font-semibold">Transaksi</span>
        </a>

    </nav>

    <!-- Logout Section -->
    <div class="px-4 py-4 border-t flex-shrink-0" style="border-color: rgba(194, 65, 12, 0.3) !important;">

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                class="w-full flex items-center gap-3 px-4 py-3 font-medium rounded-lg hover:bg-red-600 hover:text-white backdrop-blur-sm transition-all duration-200" style="color: rgba(255, 255, 255, 0.9) !important;">
                <span class="w-1 h-6 rounded-full" style="background-color: rgba(255, 255, 255, 0.7) !important;"></span>
                <span>Logout</span>
            </button>

        </form>

    </div>

</aside>