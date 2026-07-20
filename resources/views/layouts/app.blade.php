<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Coole-Bill POS')</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="h-full bg-slate-50 dark:bg-slate-900 text-gray-900 dark:text-gray-100">

<!-- Mobile Sidebar Toggle Button (Visible only on mobile) -->
<button id="sidebarToggle" 
        class="fixed top-4 left-4 md:hidden z-50 p-2 bg-orange-600 dark:bg-orange-700 rounded-lg hover:bg-orange-700 dark:hover:bg-orange-800 transition-colors"
        onclick="toggleSidebar()" style="color: #ffffff !important;">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
    </svg>
</button>

<!-- Backdrop (Mobile only, hidden by default) -->
<div id="sidebarBackdrop" 
     class="hidden fixed inset-0 bg-black/50 z-30 md:hidden"
     onclick="toggleSidebar()"></div>

<div class="flex h-full">

    <!-- Sidebar - Responsive -->
    <div id="sidebar" 
         class="fixed md:relative w-64 h-full z-40 transform -translate-x-full md:translate-x-0 transition-transform duration-300 overflow-y-auto">
        @include('layouts.sidebar')
    </div>

    <div class="flex-1 flex flex-col w-full overflow-hidden">

        @include('layouts.navbar')

        <main class="flex-1 p-4 md:p-8 bg-slate-50 dark:bg-slate-900 overflow-y-auto">

            @yield('content')

        </main>

        @include('layouts.footer')

    </div>

</div>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const backdrop = document.getElementById('sidebarBackdrop');
    
    sidebar.classList.toggle('-translate-x-full');
    sidebar.classList.toggle('translate-x-0');
    backdrop.classList.toggle('hidden');
}

// Close sidebar when clicking on a link (mobile)
document.addEventListener('DOMContentLoaded', function() {
    const sidebarLinks = document.querySelectorAll('#sidebar a, #sidebar button');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth < 768) { // md breakpoint
                toggleSidebar();
            }
        });
    });
});
</script>

</body>
</html>
