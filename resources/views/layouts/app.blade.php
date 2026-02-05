<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Inventaris')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen">
    <nav class="flex aliign-center justify-center">
        <div class="bg-blue-600 text-white shadow w-fit px-20 mt-2 rounded-4xl">

            <div class="container mx-auto px-4">
                <div class="flex justify-center py-4 space-x-8">
                    <a href="/" class="hover:text-gray-200 font-semibold">
                        Home
                    </a>
                    <a href="{{ route('inventaris.index') }}" class="hover:text-gray-200 font-semibold">
                        Inventaris
                    </a>
                    <a href="{{ route('peminjaman.index') }}" class="hover:text-gray-200 font-semibold">
                        peminjaman
                    </a>
                </div>
            </div>
        </div>
    </nav>

        @yield('content')
    </div>
</body>
</html>
