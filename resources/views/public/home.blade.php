@extends('public.layout', ['title' => 'Klub Panahan Remaja Masjid Baitul Muttaqin'])

@section('content')
    <!-- Hero Section -->
    <section id="home" class="relative overflow-hidden bg-slate-950 text-white selection:bg-amber-400 selection:text-slate-900">
        <!-- Abstract gradient background -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(16,185,129,0.15),transparent_40%),radial-gradient(circle_at_bottom_left,rgba(245,158,11,0.1),transparent_40%)]"></div>
        <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/3 opacity-30 blur-[100px]">
            <div class="h-96 w-96 rounded-full bg-emerald-500"></div>
        </div>
        
        <div class="relative mx-auto grid min-h-[700px] max-w-7xl items-center gap-12 px-4 py-24 sm:px-6 lg:grid-cols-[1.2fr_0.8fr] lg:px-8">
            <div class="z-10">
                <div class="inline-flex items-center gap-2 rounded-full border border-emerald-500/30 bg-emerald-500/10 px-4 py-2 mb-6 backdrop-blur-sm">
                    <span class="flex h-2 w-2 rounded-full bg-amber-400 animate-pulse"></span>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-300">Pendaftaran Gelombang 1 Dibuka</span>
                </div>
                <h1 class="text-5xl font-black leading-[1.1] tracking-tight sm:text-7xl lg:text-[5rem]">
                    Fokus, Disiplin, <br>
                    <span class="bg-gradient-to-r from-emerald-400 to-amber-300 bg-clip-text text-transparent">Adab Mulia.</span>
                </h1>
                <p class="mt-8 max-w-2xl text-lg leading-relaxed text-slate-300 sm:text-xl">
                    Klub Panahan Remaja Masjid Baitul Muttaqin. Wadah pembinaan karakter generasi muda Islam yang kuat jasmani, tangguh mental, dan mencintai ibadah.
                </p>
                <div class="mt-10 flex flex-wrap items-center gap-4">
                    <a href="{{ route('archery.registration.create') }}" class="group relative inline-flex items-center justify-center gap-2 rounded-full bg-amber-400 px-8 py-4 text-base font-bold text-slate-950 shadow-[0_0_40px_-10px_rgba(251,191,36,0.6)] transition-all duration-300 hover:scale-105 hover:bg-amber-300 hover:shadow-[0_0_60px_-15px_rgba(251,191,36,0.8)]">
                        <span>Daftar Sekarang</span>
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    <a href="#jadwal" class="inline-flex items-center justify-center rounded-full border border-slate-700 bg-slate-800/50 px-8 py-4 text-base font-bold text-white backdrop-blur-sm transition-all hover:bg-slate-700 hover:text-white">
                        Lihat Jadwal
                    </a>
                </div>
            </div>
            
            <div class="relative z-10 hidden lg:block">
                <div class="relative mx-auto aspect-square w-full max-w-md rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur-md shadow-2xl transform transition-transform duration-500 hover:-translate-y-4 hover:rotate-2">
                    <div class="absolute -inset-1 rounded-2xl bg-gradient-to-br from-emerald-500 to-amber-400 opacity-20 blur-lg"></div>
                    <div class="relative flex h-full flex-col items-center justify-center rounded-xl bg-slate-900 border border-slate-700/50 p-8 text-center shadow-inner overflow-hidden">
                        <div class="absolute top-0 right-0 p-3 opacity-10">
                            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg>
                        </div>
                        <div class="h-24 w-24 rounded-full bg-emerald-500/20 flex items-center justify-center mb-6 ring-4 ring-emerald-500/10">
                            <svg class="w-12 h-12 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h3 class="text-3xl font-black text-white">Memanah</h3>
                        <p class="mt-4 text-sm font-medium uppercase tracking-[0.3em] text-emerald-400">Sunnah Berbuah Berkah</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="tentang" class="relative bg-slate-50 py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center lg:max-w-4xl">
                <p class="text-sm font-bold uppercase tracking-widest text-emerald-600">Tentang Klub</p>
                <h2 class="mt-4 text-4xl font-black tracking-tight text-slate-900 sm:text-5xl">Bukan Sekadar Olahraga</h2>
                <p class="mt-6 text-lg leading-8 text-slate-600">Kami hadir untuk memberikan wadah latihan yang tertib, hangat, dan bertumbuh bagi remaja masjid. Menggabungkan olahraga jasmani dengan pembinaan ruhani.</p>
            </div>
            
            <div class="mx-auto mt-16 max-w-7xl sm:mt-20 lg:mt-24">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="group relative rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:ring-emerald-500/30">
                        <div class="mb-6 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Visi Jangka Panjang</h3>
                        <p class="mt-4 text-slate-600 leading-relaxed">Menjadi komunitas remaja masjid yang kuat jasmani, matang secara akhlak, dan senantiasa memiliki rasa cinta terhadap ibadah dan syiar Islam.</p>
                    </div>
                    
                    <div class="group relative rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:ring-amber-500/30">
                        <div class="mb-6 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600 group-hover:bg-amber-500 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2 2 0 00-2-2h-2"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Misi Pembinaan</h3>
                        <p class="mt-4 text-slate-600 leading-relaxed">Membina disiplin, keberanian, tingkat fokus yang tinggi, ukhuwah Islamiyah, dan rasa tanggung jawab melalui sistem latihan rutin dan terstruktur.</p>
                    </div>
                    
                    <div class="group relative rounded-3xl bg-white p-8 shadow-sm ring-1 ring-slate-200 transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:ring-emerald-500/30 sm:col-span-2 lg:col-span-1">
                        <div class="mb-6 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900">Manfaat Spesifik</h3>
                        <p class="mt-4 text-slate-600 leading-relaxed">Panahan melatih tingkat konsentrasi, memperbaiki postur tubuh, kesabaran ekstrim, koordinasi mata-tangan, dan ketenangan dalam mengambil setiap keputusan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Overview -->
    <section id="anggota" class="relative z-10 -mt-10 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl bg-white p-2 shadow-2xl ring-1 ring-slate-900/5">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-slate-100 rounded-2xl bg-white overflow-hidden">
                <div class="relative p-8 text-center hover:bg-slate-50 transition-colors">
                    <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">Total Anggota</p>
                    <p class="mt-4 text-5xl font-black text-slate-900">{{ $participantCount }}</p>
                </div>
                <div class="relative p-8 text-center hover:bg-slate-50 transition-colors">
                    <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">Peserta Aktif</p>
                    <p class="mt-4 text-5xl font-black text-emerald-600">{{ $activeParticipantCount }}</p>
                </div>
                <div class="relative p-8 text-center hover:bg-slate-50 transition-colors">
                    <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">Pemasukan Bulan Ini</p>
                    <p class="mt-4 text-4xl font-black text-slate-900 tracking-tight">Rp {{ number_format($monthlyIncome, 0, ',', '.') }}</p>
                </div>
                <div class="relative p-8 text-center hover:bg-slate-50 transition-colors">
                    <p class="text-sm font-semibold uppercase tracking-wide text-slate-500">Pengeluaran Bulan Ini</p>
                    <p class="mt-4 text-4xl font-black text-red-500 tracking-tight">Rp {{ number_format($monthlyExpense, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Schedule Section -->
    <section id="jadwal" class="py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-16">
                <div class="max-w-2xl">
                    <p class="text-sm font-bold uppercase tracking-widest text-emerald-600">Jadwal Latihan</p>
                    <h2 class="mt-4 text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">Agenda Rutin Kami</h2>
                </div>
                <a href="{{ route('archery.registration.create') }}" class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-6 py-3 font-bold text-white hover:bg-slate-800 transition-colors shadow-md">
                    <span>Gabung Sekarang</span>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>
            
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($schedules as $schedule)
                    <div class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-all hover:shadow-xl hover:-translate-y-1">
                        <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-emerald-400 to-emerald-600"></div>
                        <div class="p-8">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-700">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-slate-900 text-lg">{{ $schedule->title }}</h3>
                                    <p class="text-emerald-600 font-semibold">{{ $schedule->dayName() }}, {{ substr($schedule->starts_at, 0, 5) }} - {{ substr($schedule->ends_at, 0, 5) }}</p>
                                </div>
                            </div>
                            <div class="mt-6 flex items-start gap-3 text-slate-600">
                                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="text-sm leading-relaxed">{{ $schedule->location }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <h3 class="mt-2 text-sm font-semibold text-slate-900">Belum Ada Jadwal</h3>
                        <p class="mt-1 text-sm text-slate-500">Jadwal latihan rutin akan segera diumumkan oleh panitia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>


    <!-- Financial Transparency CTA -->
    <section class="relative py-24 sm:py-32 overflow-hidden">
        <div class="absolute inset-0 bg-emerald-900">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
        </div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl bg-emerald-950/50 backdrop-blur-md border border-emerald-500/20 p-8 sm:p-16 lg:flex lg:items-center lg:justify-between lg:gap-16">
                <div class="lg:max-w-2xl">
                    <div class="inline-flex items-center gap-2 rounded-full border border-amber-400/30 bg-amber-400/10 px-4 py-2 mb-6">
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-300">Transparansi Dana</span>
                    </div>
                    <h2 class="text-3xl font-black tracking-tight text-white sm:text-4xl">Laporan Keuangan Terbuka</h2>
                    <p class="mt-6 text-lg leading-8 text-emerald-100">Kami menjunjung tinggi amanah. Semua data pemasukan dari infak dan pengeluaran kegiatan dapat dipantau langsung oleh jamaah dan wali peserta.</p>
                </div>
                
                <div class="mt-10 lg:mt-0 lg:flex-shrink-0 flex flex-col gap-6">
                    <div class="rounded-2xl bg-white/10 p-6 border border-white/10 backdrop-blur-sm">
                        <div class="flex justify-between items-center gap-12">
                            <div>
                                <p class="text-emerald-200 text-sm font-medium">Saldo Kas Saat Ini</p>
                                <p class="mt-1 text-3xl font-black text-white">Rp {{ number_format($financialSummary['balance'], 0, ',', '.') }}</p>
                            </div>
                            <div class="h-12 w-12 rounded-full bg-emerald-500/20 flex items-center justify-center">
                                <svg class="w-6 h-6 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('financial-report.public') }}" class="group inline-flex w-full items-center justify-center gap-2 rounded-xl bg-white px-8 py-4 text-base font-bold text-emerald-950 transition-all hover:bg-emerald-50">
                        <span>Lihat Rincian Laporan</span>
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="bg-slate-950 border-t border-slate-800 py-12 sm:py-16 text-slate-400">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="md:col-span-2">
                    <a href="#" class="flex items-center gap-2 mb-6">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-500 text-white">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </div>
                        <span class="text-xl font-black text-white">Baitul Muttaqin <span class="text-emerald-500">Youth</span></span>
                    </a>
                    <p class="text-sm leading-relaxed max-w-sm">{{ $settings['mosque_name'] }}<br>{{ $settings['address'] }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-white mb-4">Hubungi Kami</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span class="text-slate-300">{{ $settings['whatsapp'] }}</span>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-sm font-bold uppercase tracking-wider text-white mb-4">Sosial Media</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" /></svg>
                            <span class="text-slate-300">{{ $settings['instagram'] }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 border-t border-slate-800 pt-8 text-center md:text-left flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-xs text-slate-500">&copy; {{ date('Y') }} {{ $settings['mosque_name'] }}. Hak Cipta Dilindungi.</p>
                <div class="flex gap-4 text-xs text-slate-500">
                    <span>Build with Laravel & TailwindCSS</span>
                </div>
            </div>
        </div>
    </footer>
@endsection
