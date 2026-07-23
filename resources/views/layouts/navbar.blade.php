<header class="sticky top-0 z-40 bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-100 shadow-sm">

    <div class="px-4 md:px-8 py-4 flex items-center justify-between">

        <!-- Page Title -->
        <div class="pl-12 md:pl-0">
            <h2 class="text-2xl md:text-3xl font-bold truncate" style="background: linear-gradient(to right, #ea580c, #f97316); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">
                @yield('page-title','Dashboard')
            </h2>
        </div>

        <!-- User Profile Dropdown -->
        <div class="relative flex items-center gap-3">
            
            <!-- Subscription Badge -->
            @if(Auth::user()->subscription)
            <div class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-lg {{ Auth::user()->subscription->isActive() ? (Auth::user()->subscription->daysRemaining() > 30 ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700') : 'bg-red-100 text-red-700' }}">
                @if(Auth::user()->subscription->plan_type === 'trial')
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                @else
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                @endif
                <span class="text-xs font-bold">
                    @if(Auth::user()->subscription->isActive())
                        {{ Auth::user()->subscription->daysRemaining() }} hari lagi
                    @else
                        Expired
                    @endif
                </span>
            </div>
            @endif

            <button 
                id="userMenuButton"
                class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-300 transition-all duration-200 group">
                
                <!-- Avatar -->
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-500 to-orange-600 p-0.5 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform duration-200">
                    <img
                        src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=ffffff&color=ea580c"
                        class="w-full h-full rounded-full"
                        alt="avatar">
                </div>

                <!-- User Info -->
                <div class="hidden md:block text-left">
                    <p id="userName" class="font-semibold text-sm leading-tight">
                        {{ Auth::user()->name }}
                    </p>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <span id="userRole" class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400">
                            {{ ucfirst(Auth::user()->role) }}
                        </span>
                    </div>
                </div>

                <!-- Dropdown Icon -->
                <svg id="dropdownIcon" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Dropdown Menu -->
            <div 
                id="userMenu"
                class="hidden absolute top-full right-0 mt-8 w-56 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 py-2 z-50 opacity-0 scale-95 transition-all duration-100">
                
                <!-- User Info Mobile -->
                <div class="md:hidden px-4 py-3 border-b border-slate-100 dark:border-slate-700">
                    <p class="font-semibold text-sm">
                        {{ Auth::user()->name }}
                    </p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-orange-100 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400 mt-1">
                        {{ ucfirst(Auth::user()->role) }}
                    </span>
                </div>

                <!-- Menu Items -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-slate-50 dark:hover:bg-slate-300 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span>Dashboard</span>
                </a>

                @if(Auth::user()->role === 'admin')
                <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm hover:bg-slate-50 dark:hover:bg-slate-300 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>Kelola Pengguna</span>
                </a>
                @endif

                <div class="border-t border-slate-100 dark:border-slate-700 my-2"></div>

                <!-- Theme Toggle -->
                <div class="px-4 py-2">
                    <p class="text-xs font-semibold mb-2">TEMA</p>
                    <div class="flex gap-2 mb-2">
                        <button 
                            id="lightModeBtn"
                            class="flex-1 flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span>Terang</span>
                        </button>
                        <button 
                            id="darkModeBtn"
                            class="flex-1 flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                            <span>Gelap</span>
                        </button>
                    </div>
                    <button 
                        id="resetThemeBtn"
                        class="w-full px-3 py-2 rounded-lg text-xs font-medium hover:bg-red-200 transition-colors" style="background-color: #fecaca !important; color: #991b1b !important;">
                        🔄 Reset Tema
                    </button>
                </div>

                <div class="border-t border-slate-100 dark:border-slate-700 my-2"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors w-full text-left">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

    </div>

</header>

<script>
// Dark Mode Management - Run IMMEDIATELY
(function() {
    console.log('🌓 Dark Mode Script Loaded');
    
    // Initialize dark mode from localStorage IMMEDIATELY (before DOM ready)
    const initDarkModeNow = () => {
        const theme = localStorage.getItem('theme');
        console.log('📦 Current theme in localStorage:', theme);
        
        const isDark = theme === 'dark';
        console.log('🎨 Is Dark Mode:', isDark);
        
        const htmlElement = document.documentElement;
        
        if (isDark) {
            htmlElement.classList.add('dark');
            console.log('✅ Added "dark" class to HTML (immediate)');
        } else {
            htmlElement.classList.remove('dark');
            console.log('✅ Removed "dark" class from HTML (immediate)');
        }
        
        return isDark ? 'dark' : 'light';
    };
    
    // Run immediately
    const currentTheme = initDarkModeNow();
    console.log('🚀 Initial theme:', currentTheme);

    // Update button styles based on active theme
    const updateThemeButtons = (theme) => {
        const lightBtn = document.getElementById('lightModeBtn');
        const darkBtn = document.getElementById('darkModeBtn');
        
        if (!lightBtn || !darkBtn) {
            console.warn('⚠️ Theme buttons not found');
            return;
        }

        console.log('🔘 Updating theme buttons for:', theme);

        // Reset both buttons
        lightBtn.className = 'flex-1 flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-slate-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300';
        darkBtn.className = 'flex-1 flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-slate-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300';

        // Highlight active button
        if (theme === 'dark') {
            darkBtn.className = 'flex-1 flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-orange-500 text-white shadow-sm';
            console.log('🌙 Dark button highlighted');
        } else {
            lightBtn.className = 'flex-1 flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-orange-500 text-white shadow-sm';
            console.log('☀️ Light button highlighted');
        }
    };

    // Set theme - SIMPLE TOGGLE
    const setTheme = (theme) => {
        console.log('🎯 Setting theme to:', theme);
        console.log('📍 Before change - classList:', document.documentElement.classList.toString());
        console.log('📍 Before change - localStorage:', localStorage.getItem('theme'));
        
        const htmlElement = document.documentElement;
        
        if (theme === 'dark') {
            htmlElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
            console.log('🌙 Dark mode activated');
        } else {
            htmlElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
            console.log('☀️ Light mode activated');
            console.log('🔍 Checking if "dark" class still exists:', htmlElement.classList.contains('dark'));
        }
        
        console.log('📋 After change - classList:', htmlElement.classList.toString());
        console.log('📋 After change - localStorage:', localStorage.getItem('theme'));
        
        // Force a style recalculation
        void htmlElement.offsetHeight;
        
        updateThemeButtons(theme);
    };

    // Wait for DOM to be ready for event handlers
    document.addEventListener('DOMContentLoaded', function() {
        console.log('✅ DOM Content Loaded');
        
        const userMenuButton = document.getElementById('userMenuButton');
        const userMenu = document.getElementById('userMenu');
        const dropdownIcon = document.getElementById('dropdownIcon');
        const lightModeBtn = document.getElementById('lightModeBtn');
        const darkModeBtn = document.getElementById('darkModeBtn');
        const resetThemeBtn = document.getElementById('resetThemeBtn');

        if (!lightModeBtn || !darkModeBtn) {
            console.error('❌ Theme buttons not found in DOM!');
            return;
        }

        // Initialize theme buttons
        updateThemeButtons(currentTheme);

        // Theme toggle handlers
        lightModeBtn.addEventListener('click', function(e) {
            console.log('👆 Light button clicked');
            e.preventDefault();
            e.stopPropagation();
            setTheme('light');
        });
        
        darkModeBtn.addEventListener('click', function(e) {
            console.log('👆 Dark button clicked');
            e.preventDefault();
            e.stopPropagation();
            setTheme('dark');
        });

        // Reset theme handler
        resetThemeBtn.addEventListener('click', function(e) {
            console.log('🔄 Reset button clicked');
            e.preventDefault();
            e.stopPropagation();
            
            // Clear localStorage
            localStorage.removeItem('theme');
            console.log('🗑️ Theme removed from localStorage');
            
            // Force light mode
            document.documentElement.classList.remove('dark');
            console.log('✅ Forced light mode');
            
            // Show detailed instructions
            const instructions = 
                '✅ Tema telah direset!\n\n' +
                'Langkah selanjutnya:\n' +
                '1. Klik OK\n' +
                '2. Tekan CTRL+F5 (hard refresh) untuk clear cache\n' +
                '3. Atau tekan CTRL+SHIFT+R\n\n' +
                'Halaman akan otomatis refresh.';
            
            alert(instructions);
            
            // Force reload dengan cache bypass
            window.location.reload(true);
        });

        console.log('✅ Theme toggle handlers attached');

        // Toggle dropdown
        userMenuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            const isHidden = userMenu.classList.contains('hidden');
            
            if (isHidden) {
                userMenu.classList.remove('hidden');
                setTimeout(() => {
                    userMenu.classList.remove('opacity-0', 'scale-95');
                    userMenu.classList.add('opacity-100', 'scale-100');
                }, 10);
                dropdownIcon.classList.add('rotate-180');
            } else {
                userMenu.classList.remove('opacity-100', 'scale-100');
                userMenu.classList.add('opacity-0', 'scale-95');
                dropdownIcon.classList.remove('rotate-180');
                setTimeout(() => {
                    userMenu.classList.add('hidden');
                }, 100);
            }
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userMenu.contains(e.target) && !userMenuButton.contains(e.target)) {
                if (!userMenu.classList.contains('hidden')) {
                    userMenu.classList.remove('opacity-100', 'scale-100');
                    userMenu.classList.add('opacity-0', 'scale-95');
                    dropdownIcon.classList.remove('rotate-180');
                    setTimeout(() => {
                        userMenu.classList.add('hidden');
                    }, 100);
                }
            }
        });
    });
})();
</script>