@extends('public.layout', ['title' => 'Pendaftaran Lomba Panahan 17 Agustus 2026'])

@section('content')
    <section class="relative overflow-hidden bg-slate-950 py-16 text-white sm:py-24">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(16,185,129,0.22),transparent_42%),radial-gradient(circle_at_bottom_right,rgba(245,158,11,0.16),transparent_38%)]"></div>
        <div class="relative mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
                <div>
                    <div class="inline-flex items-center rounded-full border border-amber-300/30 bg-amber-300/10 px-4 py-2 text-xs font-bold uppercase tracking-wider text-amber-200">
                        Pendaftaran Lomba 17 Agustus 2026
                    </div>
                    <h1 class="mt-6 text-4xl font-black leading-tight tracking-tight sm:text-5xl">
                        Lomba Panahan Masjid Baitul Muttaqin
                    </h1>
                    <p class="mt-5 max-w-2xl text-lg leading-8 text-slate-300">
                        Daftarkan peserta untuk mengikuti lomba panahan dalam rangka 17 Agustus 2026.
                    </p>
                </div>

                <div class="rounded-2xl border border-white/10 bg-white/10 p-6 shadow-2xl backdrop-blur">
                    <dl class="grid gap-5 text-sm">
                        <div>
                            <dt class="font-bold uppercase tracking-wider text-emerald-300">Tanggal</dt>
                            <dd class="mt-1 text-2xl font-black text-white">1 & 2 Agustus 2026</dd>
                        </div>
                        <div>
                            <dt class="font-bold uppercase tracking-wider text-emerald-300">Mulai</dt>
                            <dd class="mt-1 text-2xl font-black text-white">07.30 WIB</dd>
                        </div>
                        <div>
                            <dt class="font-bold uppercase tracking-wider text-emerald-300">Kategori</dt>
                            <dd class="mt-2 flex flex-wrap gap-2">
                                @foreach (['Kelas 3-6 Pria', 'Kelas 3-6 Wanita', 'Remaja', 'Dewasa Pria'] as $category)
                                    <span class="rounded-full bg-white/10 px-3 py-1 text-slate-100 ring-1 ring-white/10">{{ $category }}</span>
                                @endforeach
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </section>

    <section class="relative -mt-8 mx-auto max-w-3xl px-4 pb-24 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-8 rounded-2xl border border-emerald-200 bg-emerald-50 p-6 shadow-sm">
                <h3 class="font-bold text-emerald-900 text-lg">Pendaftaran Berhasil</h3>
                <p class="mt-1 text-emerald-700">{{ session('success') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('archery.competition.store') }}" class="overflow-hidden rounded-2xl bg-white shadow-xl shadow-slate-200/60 ring-1 ring-slate-100">
            @csrf

            <div class="border-b border-slate-100 p-6 sm:p-8">
                <h2 class="text-2xl font-black text-slate-900">Data Peserta</h2>
                <p class="mt-2 text-sm leading-6 text-slate-500">Isi data sesuai peserta yang akan mengikuti lomba.</p>

                <div class="mt-8 grid gap-6 sm:grid-cols-2">
                    <label class="space-y-2 sm:col-span-2">
                        <span class="text-sm font-semibold text-slate-700">Nama Lengkap</span>
                        <input name="name" value="{{ old('name') }}" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 transition-colors placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20" placeholder="Nama peserta" required>
                        @error('name') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </label>

                    <label class="space-y-2">
                        <span class="text-sm font-semibold text-slate-700">Nomor WhatsApp</span>
                        <input name="whatsapp" value="{{ old('whatsapp') }}" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 transition-colors placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20" placeholder="Contoh: 08123456789" required>
                        @error('whatsapp') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </label>

                    <label class="space-y-2">
                        <span class="text-sm font-semibold text-slate-700">RT</span>
                        <input name="rt" value="{{ old('rt') }}" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 transition-colors placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20" placeholder="Contoh: 03" required>
                        @error('rt') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </label>

                    <fieldset class="space-y-3 sm:col-span-2">
                        <legend class="text-sm font-semibold text-slate-700">Kategori Lomba</legend>
                        <div class="grid gap-3 sm:grid-cols-2">
                            @foreach ([
                                'kelas_3_6_pria' => 'Kelas 3-6 Pria',
                                'kelas_3_6_wanita' => 'Kelas 3-6 Wanita',
                                'remaja' => 'Remaja',
                                'dewasa_pria' => 'Dewasa Pria',
                            ] as $value => $label)
                                <label class="flex cursor-pointer items-center justify-between rounded-xl border border-slate-200 bg-white p-4 font-semibold text-slate-700 transition-colors hover:bg-slate-50 [&:has(:checked)]:border-emerald-500 [&:has(:checked)]:bg-emerald-50 [&:has(:checked)]:text-emerald-800">
                                    <span>{{ $label }}</span>
                                    <input type="radio" name="competition_category" value="{{ $value }}" class="h-5 w-5 text-emerald-600 focus:ring-emerald-500" @checked(old('competition_category') === $value) required>
                                </label>
                            @endforeach
                        </div>
                        @error('competition_category') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </fieldset>

                    <label class="space-y-2 sm:col-span-2">
                        <span class="text-sm font-semibold text-slate-700">Catatan Tambahan (Opsional)</span>
                        <textarea name="suggestion" rows="3" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 transition-colors placeholder:text-slate-400 focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20" placeholder="Tuliskan catatan untuk panitia jika ada">{{ old('suggestion') }}</textarea>
                        @error('suggestion') <p class="text-sm text-red-500">{{ $message }}</p> @enderror
                    </label>
                </div>
            </div>

            <div class="flex justify-end bg-slate-50 p-6 sm:px-8">
                <button class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-8 py-3.5 text-base font-bold text-white shadow-md transition-all hover:-translate-y-0.5 hover:bg-emerald-700 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                    <span>Kirim Pendaftaran</span>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </form>
    </section>
@endsection
