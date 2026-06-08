@extends('public.layout', ['title' => 'Pendaftaran Panahan Remaja'])

@section('content')
    <section class="relative bg-slate-900 py-16 sm:py-24 text-white overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,rgba(16,185,129,0.2),transparent_50%)]"></div>
        <div class="relative mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center justify-center rounded-full bg-emerald-500/10 px-4 py-1.5 text-sm font-bold text-emerald-400 mb-6 ring-1 ring-emerald-500/20 backdrop-blur-sm">
                Formulir Pendaftaran
            </div>
            <h1 class="text-4xl sm:text-5xl font-black tracking-tight mb-4">Klub Panahan Remaja</h1>
            <p class="text-lg text-slate-400 max-w-2xl mx-auto">Silakan lengkapi data orang tua, data peserta, serta persetujuan latihan di bawah ini.</p>
        </div>
    </section>

    <section class="relative -mt-8 mx-auto max-w-4xl px-4 pb-24 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-8 rounded-2xl border border-emerald-200 bg-emerald-50 p-6 shadow-sm flex items-start gap-4">
                <div class="rounded-full bg-emerald-100 p-2 text-emerald-600 flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-emerald-900 text-lg">Pendaftaran Berhasil</h3>
                    <p class="mt-1 text-emerald-700">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('archery.registration.store') }}" class="rounded-3xl bg-white shadow-xl shadow-slate-200/50 ring-1 ring-slate-100 overflow-hidden">
            @csrf
            
            <!-- Data Orang Tua -->
            <div class="p-8 sm:p-10 border-b border-slate-100">
                <div class="flex items-center gap-4 mb-8">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600 font-black">1</div>
                    <h2 class="text-2xl font-bold text-slate-900">Data Orang Tua / Wali</h2>
                </div>
                
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700">Nama Lengkap</label>
                        <input name="parent_name" value="{{ old('parent_name') }}" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 transition-colors focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 placeholder:text-slate-400" placeholder="Contoh: Budi Santoso" required>
                        @error('parent_name') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700">Nomor WhatsApp</label>
                        <input name="parent_whatsapp" value="{{ old('parent_whatsapp') }}" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 transition-colors focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 placeholder:text-slate-400" placeholder="Contoh: 08123456789" required>
                        @error('parent_whatsapp') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="space-y-1 md:col-span-2">
                        <label class="text-sm font-semibold text-slate-700">Alamat Lengkap</label>
                        <textarea name="parent_address" rows="3" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 transition-colors focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 placeholder:text-slate-400" placeholder="Masukkan alamat lengkap domisili" required>{{ old('parent_address') }}</textarea>
                        @error('parent_address') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Data Anak -->
            <div class="p-8 sm:p-10 border-b border-slate-100 bg-slate-50/50">
                <div class="flex items-center gap-4 mb-8">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600 font-black">2</div>
                    <h2 class="text-2xl font-bold text-slate-900">Data Peserta (Anak)</h2>
                </div>
                
                <div class="grid gap-6 md:grid-cols-3">
                    <div class="space-y-1 md:col-span-2">
                        <label class="text-sm font-semibold text-slate-700">Nama Lengkap Anak</label>
                        <input name="child_name" value="{{ old('child_name') }}" class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-slate-900 transition-colors focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20" required>
                        @error('child_name') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="space-y-1">
                        <label class="text-sm font-semibold text-slate-700">Usia (Tahun)</label>
                        <input type="number" name="child_age" value="{{ old('child_age') }}" class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-slate-900 transition-colors focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20" required>
                        @error('child_age') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div class="space-y-1 md:col-span-3">
                        <label class="text-sm font-semibold text-slate-700">Kelas / Asal Sekolah</label>
                        <input name="child_school_class" value="{{ old('child_school_class') }}" class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-slate-900 transition-colors focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20" placeholder="Contoh: Kelas 7 SMP Islam Terpadu" required>
                        @error('child_school_class') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Persetujuan & Komitmen -->
            <div class="p-8 sm:p-10">
                <div class="flex items-center gap-4 mb-8">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600 font-black">3</div>
                    <h2 class="text-2xl font-bold text-slate-900">Persetujuan & Komitmen</h2>
                </div>
                
                <div class="grid gap-10 lg:grid-cols-2">
                    <!-- Persetujuan -->
                    <div>
                        <h3 class="text-base font-bold text-slate-900 mb-4">Izin Mengikuti Latihan</h3>
                        <div class="space-y-3">
                            <label class="flex cursor-pointer items-center justify-between rounded-xl border border-slate-200 bg-white p-4 hover:bg-slate-50 [&:has(:checked)]:border-emerald-500 [&:has(:checked)]:bg-emerald-50/50 transition-colors">
                                <span class="font-medium text-slate-700">Ya, saya mengizinkan</span>
                                <input type="radio" name="training_permission" value="1" class="h-5 w-5 text-emerald-600 focus:ring-emerald-500" @checked(old('training_permission', '1') === '1')>
                            </label>
                            <label class="flex cursor-pointer items-center justify-between rounded-xl border border-slate-200 bg-white p-4 hover:bg-slate-50 [&:has(:checked)]:border-emerald-500 [&:has(:checked)]:bg-emerald-50/50 transition-colors">
                                <span class="font-medium text-slate-700">Tidak Mengizinkan</span>
                                <input type="radio" name="training_permission" value="0" class="h-5 w-5 text-emerald-600 focus:ring-emerald-500" @checked(old('training_permission') === '0')>
                            </label>
                        </div>
                    </div>

                    <!-- Infak -->
                    <div>
                        <h3 class="text-base font-bold text-slate-900 mb-4">Komitmen Infak Mingguan</h3>
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            @foreach ([5000, 10000, 15000] as $amount)
                                <label class="flex cursor-pointer items-center justify-center rounded-xl border border-slate-200 bg-white p-3 text-center hover:bg-slate-50 [&:has(:checked)]:border-emerald-500 [&:has(:checked)]:bg-emerald-50 [&:has(:checked)]:text-emerald-700 transition-colors font-semibold text-slate-600">
                                    <input type="radio" name="weekly_donation_choice" value="{{ $amount }}" class="sr-only" @checked(old('weekly_donation_choice', '5000') == $amount)>
                                    Rp {{ number_format($amount, 0, ',', '.') }}
                                </label>
                            @endforeach
                            <label class="flex cursor-pointer items-center justify-center rounded-xl border border-slate-200 bg-white p-3 text-center hover:bg-slate-50 [&:has(:checked)]:border-emerald-500 [&:has(:checked)]:bg-emerald-50 [&:has(:checked)]:text-emerald-700 transition-colors font-semibold text-slate-600">
                                <input type="radio" name="weekly_donation_choice" value="other" class="sr-only" @checked(old('weekly_donation_choice') === 'other')>
                                Lainnya
                            </label>
                        </div>
                        <input type="number" name="weekly_donation_other" value="{{ old('weekly_donation_other') }}" placeholder="Nominal lain (Rp)" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 transition-colors focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 placeholder:text-slate-400">
                    </div>

                    <!-- Peralatan -->
                    <div class="lg:col-span-2" x-data="{ equipmentOption: '{{ old('equipment_option', 'self_purchase_full') }}' }">
                        <h3 class="text-base font-bold text-slate-900 mb-4">Opsi Peralatan Memanah</h3>
                        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-3">
                            <label class="flex flex-col cursor-pointer justify-between rounded-xl border border-slate-200 bg-white p-4 hover:bg-slate-50 [&:has(:checked)]:border-emerald-500 [&:has(:checked)]:bg-emerald-50/50 transition-colors">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="font-bold text-slate-900 text-sm">Beli Sendiri Busur & Anak Panah</span>
                                    <input type="radio" name="equipment_option" value="self_purchase_full" class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 flex-shrink-0 ml-2" x-model="equipmentOption">
                                </div>
                                <span class="text-xs text-slate-500 leading-relaxed">Peralatan komplit mandiri.</span>
                            </label>
                            <label class="flex flex-col cursor-pointer justify-between rounded-xl border border-slate-200 bg-white p-4 hover:bg-slate-50 [&:has(:checked)]:border-emerald-500 [&:has(:checked)]:bg-emerald-50/50 transition-colors">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="font-bold text-slate-900 text-sm">Beli Sendiri Anak Panah</span>
                                    <input type="radio" name="equipment_option" value="self_purchase_arrows" class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 flex-shrink-0 ml-2" x-model="equipmentOption">
                                </div>
                                <span class="text-xs text-slate-500 leading-relaxed">Hanya beli anak panah mandiri.</span>
                            </label>
                            <label class="flex flex-col cursor-pointer justify-between rounded-xl border border-slate-200 bg-white p-4 hover:bg-slate-50 [&:has(:checked)]:border-emerald-500 [&:has(:checked)]:bg-emerald-50/50 transition-colors">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="font-bold text-slate-900 text-sm">Fasilitas Panitia</span>
                                    <input type="radio" name="equipment_option" value="provided_by_committee" class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 flex-shrink-0 ml-2" x-model="equipmentOption">
                                </div>
                                <span class="text-xs text-slate-500 leading-relaxed">Pinjam alat panitia.</span>
                            </label>
                            <label class="flex flex-col cursor-pointer justify-between rounded-xl border border-slate-200 bg-white p-4 hover:bg-slate-50 [&:has(:checked)]:border-emerald-500 [&:has(:checked)]:bg-emerald-50/50 transition-colors">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="font-bold text-slate-900 text-sm">Siap Urunan</span>
                                    <input type="radio" name="equipment_option" value="shared_contribution" class="h-5 w-5 text-emerald-600 focus:ring-emerald-500 flex-shrink-0 ml-2" x-model="equipmentOption">
                                </div>
                                <span class="text-xs text-slate-500 leading-relaxed">Bersedia patungan.</span>
                            </label>
                        </div>

                        <!-- Info Harga Perlengkapan -->
                        <div class="mt-6 rounded-xl border border-emerald-100 bg-emerald-50/50 p-4 text-sm text-emerald-900 leading-relaxed">
                            <h4 class="font-bold text-emerald-800 mb-2">💡 Info Harga Perlengkapan (Gambaran):</h4>
                            <div class="space-y-3">
                                <div>
                                    <strong class="text-emerald-800">Quiver (Wadah Anak Panah):</strong>
                                    <ul class="list-disc pl-5 mt-1 space-y-1 text-emerald-700">
                                        <li>Tabung Standar (Tube Quiver): Rp50.000 - Rp90.000</li>
                                        <li>Quiver Pinggang (Side/Hip Quiver): Rp40.000 - Rp200.000 (tergantung kualitas bahan & desain)</li>
                                    </ul>
                                </div>
                                <div>
                                    <strong class="text-emerald-800">Arrow (Anak Panah):</strong>
                                    <p class="mt-1 text-emerald-700">Harga anak panah dari bahan bambu petung berkisar antara <strong>Rp9.500 hingga Rp35.000 per biji</strong>. Sering dijual juga dalam paket per 6 biji atau selusin.</p>
                                </div>
                                <div class="pt-2 border-t border-emerald-200">
                                    <p class="text-emerald-700">Pembelian dapat dilakukan di Shopee atau toko online lainnya.</p>
                                    <p class="text-emerald-700 mt-1">Atau bisa tanya-tanya di <strong>Riana Archery (KBB)</strong>: <a href="https://wa.me/6285156866838" target="_blank" class="text-emerald-600 hover:text-emerald-800 underline font-medium inline-flex items-center gap-1"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg> WhatsApp Riana Archery</a></p>
                                </div>
                            </div>
                        </div>

                        <!-- Nominal Urunan Input (Visible only if Siap Urunan is selected) -->
                        <div class="mt-4" x-show="equipmentOption === 'shared_contribution'" style="display: none;" x-transition>
                            <label class="block space-y-1">
                                <span class="text-sm font-semibold text-slate-700">Nominal Urunan yang Disanggupi (Rp) <span class="text-red-500">*</span></span>
                                <input type="number" name="equipment_contribution_amount" value="{{ old('equipment_contribution_amount') }}" placeholder="Contoh: 150000" class="w-full rounded-xl border-slate-200 bg-white px-4 py-3 text-slate-900 transition-colors focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 placeholder:text-slate-400">
                                @error('equipment_contribution_amount') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
                            </label>
                            <p class="mt-1.5 text-xs text-slate-500">Pembayaran urunan ini hanya dibayarkan sekali (one-time payment).</p>
                        </div>
                    </div>

                    <div class="lg:col-span-2">
                        <label class="block space-y-2">
                            <span class="text-sm font-semibold text-slate-700">Catatan / Saran Tambahan (Opsional)</span>
                            <textarea name="suggestion" rows="3" class="w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-slate-900 transition-colors focus:border-emerald-500 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 placeholder:text-slate-400" placeholder="Tuliskan jika ada kondisi kesehatan khusus atau saran">{{ old('suggestion') }}</textarea>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="p-8 sm:px-10 bg-slate-50 border-t border-slate-100 flex justify-end">
                <button class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-8 py-3.5 text-base font-bold text-white shadow-md hover:bg-emerald-700 hover:shadow-lg transition-all hover:-translate-y-0.5 focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:outline-none">
                    <span>Kirim Formulir Pendaftaran</span>
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </div>
        </form>
    </section>
@endsection
