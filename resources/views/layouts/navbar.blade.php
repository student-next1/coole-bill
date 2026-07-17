<header class="sticky top-0 z-40 bg-white border-b border-slate-200 shadow-sm">

    <div class="px-8 py-5 flex items-center justify-between">

        <div>
            <h2 class="text-3xl font-bold bg-gradient-to-r from-orange-600 to-orange-500 bg-clip-text text-transparent">
                @yield('page-title','Dashboard')
            </h2>
        </div>

        <div class="flex items-center gap-4">

            <div class="text-right">
                <p class="font-semibold text-gray-900">
                    {{ Auth::user()->name }}
                </p>
                <p class="text-xs text-gray-500 uppercase tracking-wide">
                    {{ ucfirst(Auth::user()->role) }}
                </p>
            </div>

            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-orange-500 to-orange-600 p-0.5 flex items-center justify-center">
                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=ffffff&color=ea580c"
                    class="w-full h-full rounded-full"
                    alt="avatar">
            </div>

        </div>

    </div>

</header>