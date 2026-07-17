<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Coole-Bill POS')</title>

    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-slate-50 text-gray-900">

<div class="flex min-h-screen">

    @include('layouts.sidebar')

    <div class="flex-1 flex flex-col">

        @include('layouts.navbar')

        <main class="flex-1 p-8 bg-slate-50">

            @yield('content')

        </main>

        @include('layouts.footer')

    </div>

</div>

</body>
</html>