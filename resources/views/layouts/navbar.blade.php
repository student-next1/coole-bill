<header class="sticky top-0 z-40 bg-white border-b border-slate-200 shadow-sm">

    <div class="px-4 md:px-8 py-5 flex items-center justify-between">

        <div class="pl-12 md:pl-0">
            <h2 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-orange-600 to-orange-500 bg-clip-text text-transparent truncate">
                @yield('page-title','Dashboard')
            </h2>
        </div>

        <div class="flex items-center gap-4">

            <div class="text-right">
                <p class="font-semibold text-gray-900 text-sm md:text-base">
                    {{ Auth::user()->name }}
                </p>
                <p class="text-xs text-gray-500 uppercase tracking-wide">
                    {{ ucfirst(Auth::user()->role) }}
                </p>
            </div>

            <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-gradient-to-br from-orange-500 to-orange-600 p-0.5 flex items-center justify-center flex-shrink-0">
                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=ffffff&color=ea580c"
                    class="w-full h-full rounded-full"
                    alt="avatar">
            </div>

        </div>

    </div>

</header>