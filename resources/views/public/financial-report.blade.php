@extends('public.layout', ['title' => 'Laporan Keuangan Publik'])

@section('content')
    <section class="relative bg-slate-900 py-16 sm:py-24 text-white overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom,rgba(16,185,129,0.2),transparent_60%)]"></div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center justify-center rounded-full bg-amber-400/10 px-4 py-1.5 text-sm font-bold text-amber-400 mb-6 ring-1 ring-amber-400/20 backdrop-blur-sm">
                Transparansi Dana Umat
            </div>
            <h1 class="text-4xl sm:text-5xl font-black tracking-tight mb-4">Laporan Keuangan Publik</h1>
            <p class="text-lg text-slate-400 max-w-2xl mx-auto">Kami berkomitmen untuk melaporkan secara terbuka seluruh pemasukan infak dan pengeluaran operasional.</p>
        </div>
    </section>

    <section class="relative -mt-10 mx-auto max-w-7xl px-4 pb-24 sm:px-6 lg:px-8 z-10">
        <!-- Overview Cards -->
        <div class="grid gap-6 md:grid-cols-3">
            <div class="relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl shadow-slate-200/50 ring-1 ring-slate-100 transition-all hover:-translate-y-1">
                <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-emerald-500/10 blur-xl"></div>
                <div class="flex items-center gap-4 mb-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-wide">Total Pemasukan</p>
                </div>
                <p class="text-4xl font-black tracking-tight text-slate-900">Rp {{ number_format($summary['income'], 0, ',', '.') }}</p>
            </div>
            
            <div class="relative overflow-hidden rounded-3xl bg-white p-8 shadow-xl shadow-slate-200/50 ring-1 ring-slate-100 transition-all hover:-translate-y-1">
                <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-red-500/10 blur-xl"></div>
                <div class="flex items-center gap-4 mb-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-100 text-red-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                    </div>
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-wide">Total Pengeluaran</p>
                </div>
                <p class="text-4xl font-black tracking-tight text-slate-900">Rp {{ number_format($summary['expense'], 0, ',', '.') }}</p>
            </div>
            
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 to-emerald-900 p-8 shadow-xl shadow-emerald-900/20 ring-1 ring-emerald-500/30 transition-all hover:-translate-y-1 text-white">
                <div class="absolute -right-6 -bottom-6 h-32 w-32 rounded-full bg-white/10 blur-2xl"></div>
                <div class="flex items-center gap-4 mb-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/20 backdrop-blur-sm text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                    </div>
                    <p class="text-sm font-bold text-emerald-100 uppercase tracking-wide">Saldo Kas Tersedia</p>
                </div>
                <p class="text-4xl font-black tracking-tight text-white">Rp {{ number_format($summary['balance'], 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="mt-8 rounded-3xl border border-slate-200 bg-white p-6 sm:p-8 shadow-sm">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-slate-100 pb-6">
                <div>
                    <h2 class="text-2xl font-black text-slate-900">Grafik Arus Kas</h2>
                    <p class="text-sm text-slate-500 mt-1">Pantau pergerakan dana per bulan</p>
                </div>
                <form class="flex flex-wrap gap-3 items-center bg-slate-50 p-2 rounded-2xl border border-slate-200/60">
                    <input type="number" name="year" value="{{ $year }}" class="w-24 rounded-xl border-slate-200 bg-white py-2 px-3 text-sm font-semibold text-slate-700 focus:border-emerald-500 focus:ring-emerald-500">
                    <select name="month" class="rounded-xl border-slate-200 bg-white py-2 pl-3 pr-8 text-sm font-semibold text-slate-700 focus:border-emerald-500 focus:ring-emerald-500 cursor-pointer">
                        <option value="">Semua bulan</option>
                        @foreach (range(1, 12) as $item)
                            <option value="{{ $item }}" @selected($month === $item)>{{ DateTime::createFromFormat('!m', $item)->format('F') }}</option>
                        @endforeach
                    </select>
                    <button class="rounded-xl bg-slate-900 px-5 py-2 text-sm font-bold text-white hover:bg-emerald-700 transition-colors shadow-sm">Filter</button>
                    <a href="{{ route('financial-report.export-excel', array_filter(['year' => $year, 'month' => $month])) }}" class="inline-flex items-center gap-2 rounded-xl bg-emerald-700 px-5 py-2 text-sm font-bold text-white hover:bg-emerald-800 transition-colors shadow-sm">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v12m0 0l-4-4m4 4l4-4M4 20h16"></path></svg>
                        Export Excel
                    </a>
                </form>
            </div>
            <div class="relative w-full overflow-hidden rounded-xl bg-slate-50/50 p-2">
                <canvas id="cashflowChart" height="100"></canvas>
            </div>
        </div>

        <!-- History Tables -->
        <div class="mt-8 grid gap-8 lg:grid-cols-2">
            <!-- Pemasukan -->
            <div class="rounded-3xl border border-emerald-100 bg-white overflow-hidden shadow-sm flex flex-col">
                <div class="bg-emerald-50/50 p-6 border-b border-emerald-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Riwayat Pemasukan</h2>
                        <p class="text-xs text-slate-500 mt-1">Data terbaru pemasukan dana</p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                </div>
                <div class="p-0 flex-1">
                    <ul class="divide-y divide-slate-100">
                        @forelse ($incomes as $income)
                            <li class="group flex justify-between gap-4 p-6 transition-colors hover:bg-slate-50">
                                <div>
                                    <p class="font-bold text-slate-900 group-hover:text-emerald-700 transition-colors">{{ $income->source }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600">{{ $income->category->name }}</span>
                                        <span class="text-xs text-slate-400">{{ $income->date->format('d M Y') }}</span>
                                    </div>
                                </div>
                                <p class="font-black text-emerald-600 shrink-0 self-center">+ Rp {{ number_format($income->amount, 0, ',', '.') }}</p>
                            </li>
                        @empty
                            <li class="p-8 text-center">
                                <p class="text-sm text-slate-500">Belum ada pemasukan yang tercatat.</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Pengeluaran -->
            <div class="rounded-3xl border border-red-100 bg-white overflow-hidden shadow-sm flex flex-col">
                <div class="bg-red-50/50 p-6 border-b border-red-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Riwayat Pengeluaran</h2>
                        <p class="text-xs text-slate-500 mt-1">Data terbaru penggunaan dana</p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                    </div>
                </div>
                <div class="p-0 flex-1">
                    <ul class="divide-y divide-slate-100">
                        @forelse ($expenses as $expense)
                            <li class="group flex justify-between gap-4 p-6 transition-colors hover:bg-slate-50">
                                <div>
                                    <p class="font-bold text-slate-900 group-hover:text-red-700 transition-colors">{{ $expense->description ?? $expense->category->name }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="inline-flex items-center rounded-md bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600">{{ $expense->category->name }}</span>
                                        <span class="text-xs text-slate-400">{{ $expense->date->format('d M Y') }}</span>
                                    </div>
                                </div>
                                <p class="font-black text-red-500 shrink-0 self-center">- Rp {{ number_format($expense->amount, 0, ',', '.') }}</p>
                            </li>
                        @empty
                            <li class="p-8 text-center">
                                <p class="text-sm text-slate-500">Belum ada pengeluaran yang tercatat.</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Chart Configuration -->
    <script>
        const ctx = document.getElementById('cashflowChart').getContext('2d');
        
        // Gradient for Income
        const incomeGradient = ctx.createLinearGradient(0, 0, 0, 400);
        incomeGradient.addColorStop(0, 'rgba(16, 185, 129, 0.8)');   // Emerald-500
        incomeGradient.addColorStop(1, 'rgba(5, 150, 105, 0.2)');    // Emerald-600 fade
        
        // Gradient for Expense
        const expenseGradient = ctx.createLinearGradient(0, 0, 0, 400);
        expenseGradient.addColorStop(0, 'rgba(239, 68, 68, 0.8)');   // Red-500
        expenseGradient.addColorStop(1, 'rgba(220, 38, 38, 0.2)');   // Red-600 fade

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json(array_column($cashflow, 'month')),
                datasets: [
                    { 
                        label: 'Pemasukan', 
                        data: @json(array_column($cashflow, 'income')), 
                        backgroundColor: incomeGradient,
                        borderRadius: 6,
                        borderWidth: 0,
                        barPercentage: 0.6,
                        categoryPercentage: 0.8
                    },
                    { 
                        label: 'Pengeluaran', 
                        data: @json(array_column($cashflow, 'expense')), 
                        backgroundColor: expenseGradient,
                        borderRadius: 6,
                        borderWidth: 0,
                        barPercentage: 0.6,
                        categoryPercentage: 0.8
                    }
                ]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'end',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8,
                            font: { family: "'Outfit', sans-serif", weight: '600' }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 23, 42, 0.9)',
                        titleFont: { family: "'Outfit', sans-serif", size: 14 },
                        bodyFont: { family: "'Outfit', sans-serif", size: 14 },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: { 
                    y: { 
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(226, 232, 240, 0.6)',
                            drawBorder: false,
                        },
                        ticks: {
                            font: { family: "'Outfit', sans-serif" },
                            callback: function(value) {
                                if (value === 0) return '0';
                                return value >= 1000000 ? (value / 1000000) + ' Jt' : (value / 1000) + ' Rb';
                            }
                        }
                    },
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { font: { family: "'Outfit', sans-serif" } }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
            }
        });
    </script>
@endsection
