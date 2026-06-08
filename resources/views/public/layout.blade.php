<!doctype html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Baitul Muttaqin Youth Management System' }}</title>
    
    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    @unless (app()->environment('testing'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endunless
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased selection:bg-emerald-200 selection:text-emerald-900">
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-900 text-white transition-transform duration-300 group-hover:-rotate-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"></path>
                    </svg>
                </div>
                <span class="text-xl font-bold tracking-tight text-slate-900">MBM<span class="text-slate-500 font-medium">Youth</span></span>
            </a>
            
            <!-- Desktop Menu -->
            <div class="hidden items-center gap-8 text-sm font-medium text-slate-500 md:flex">
                <a href="{{ route('home') }}#tentang" class="hover:text-slate-900 transition-colors">Tentang</a>
                <a href="{{ route('home') }}#jadwal" class="hover:text-slate-900 transition-colors">Jadwal</a>
                <a href="{{ route('financial-report.public') }}" class="hover:text-slate-900 transition-colors">Laporan Keuangan</a>
                <a href="{{ route('archery.registration.create') }}" class="rounded-full bg-slate-900 px-5 py-2.5 font-semibold text-white transition-all hover:bg-slate-800 hover:shadow-md">
                    Daftar Panahan
                </a>
            </div>
            
            <!-- Mobile Menu Button -->
            <button class="md:hidden text-slate-900 p-2 -mr-2 rounded-lg hover:bg-slate-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
        </nav>
    </header>

    <main class="min-h-screen">
        @yield('content')
    </main>
</body>
</html>
