<div class="space-y-6">

    <div class="flex h-full w-full flex-1 flex-col gap-6">
        {{-- Statistik Utama --}}
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">

            {{-- Kartu Produk Hukum --}}
            <div
                class="group relative overflow-hidden rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md dark:border-neutral-800 dark:bg-zinc-900">
                <div class="relative z-10 flex items-center gap-4">
                    <div
                        class="flex size-12 items-center justify-center rounded-xl bg-yellow-50 text-yellow-600 transition-colors group-hover:bg-yellow-100 dark:bg-yellow-500/10 dark:text-yellow-400">
                        <flux:icon.document-text class="size-6" />
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-widest text-neutral-500 dark:text-neutral-400">
                            Produk Hukum</p>
                        <h2 class="text-3xl font-black text-neutral-900 dark:text-neutral-100">
                            {{ $countKeputusan ?? 0 }}</h2>
                    </div>
                </div>
                <div
                    class="absolute -right-4 -top-4 size-24 rounded-full bg-yellow-500/5 transition-transform group-hover:scale-150">
                </div>
            </div>

            {{-- Kartu Data Dukung --}}
            <div
                class="group relative overflow-hidden rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md dark:border-neutral-800 dark:bg-zinc-900">
                <div class="relative z-10 flex items-center gap-4">
                    <div
                        class="flex size-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 transition-colors group-hover:bg-indigo-100 dark:bg-indigo-500/10 dark:text-indigo-400">
                        <flux:icon.folder class="size-6" />
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-widest text-neutral-500 dark:text-neutral-400">
                            Penyusunan Produk Hukum</p>
                        <h2 class="text-3xl font-black text-neutral-900 dark:text-neutral-100">
                            {{ $countDataDukung ?? 0 }}</h2>
                    </div>
                </div>
                <div
                    class="absolute -right-4 -top-4 size-24 rounded-full bg-indigo-500/5 transition-transform group-hover:scale-150">
                </div>
            </div>

            {{-- Kartu Rincian Kegiatan --}}
            <div
                class="group relative overflow-hidden rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md dark:border-neutral-800 dark:bg-zinc-900">
                <div class="relative z-10 flex items-center gap-4">
                    <div
                        class="flex size-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 transition-colors group-hover:bg-emerald-100 dark:bg-emerald-500/10 dark:text-emerald-400">
                        <flux:icon.check-circle class="size-6" />
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-widest text-neutral-500 dark:text-neutral-400">
                            Rincian Data Dukung</p>
                        <h2 class="text-3xl font-black text-neutral-900 dark:text-neutral-100">{{ $countDetails ?? 0 }}
                        </h2>
                    </div>
                </div>
                <div
                    class="absolute -right-4 -top-4 size-24 rounded-full bg-emerald-500/5 transition-transform group-hover:scale-150">
                </div>
            </div>

            {{-- Kartu Pejabat Berwenang --}}
            <div
                class="group relative overflow-hidden rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-md dark:border-neutral-800 dark:bg-zinc-900">
                <div class="relative z-10 flex items-center gap-4">
                    <div
                        class="flex size-12 items-center justify-center rounded-xl bg-rose-50 text-rose-600 transition-colors group-hover:bg-rose-100 dark:bg-rose-500/10 dark:text-rose-400">
                        <flux:icon.briefcase class="size-6" />
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-widest text-neutral-500 dark:text-neutral-400">
                            Pejabat Berwenang</p>
                        <h2 class="text-3xl font-black text-neutral-900 dark:text-neutral-100">{{ $countPejabat ?? 0 }}
                        </h2>
                    </div>
                </div>
                {{-- Decorative element --}}
                <div
                    class="absolute -right-4 -top-4 size-24 rounded-full bg-rose-500/5 transition-transform group-hover:scale-150">
                </div>
            </div>
        </div>

        {{-- Area Grafik --}}
        <div class="rounded-2xl border border-neutral-200 bg-white dark:border-neutral-800 dark:bg-zinc-900">
            <div class="flex items-center justify-between border-b border-neutral-100 p-6 dark:border-neutral-800">
                <div>
                    <flux:heading size="lg">Statistik Visual</flux:heading>
                    <flux:subheading>Perbandingan volume data antar modul</flux:subheading>
                </div>
                <div class="hidden sm:block">
                    <span
                        class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 dark:bg-blue-400/10 dark:text-blue-400">Terupdate
                        Otomatis</span>
                </div>
            </div>

            <div class="p-6">
                <div class="h-[350px] w-full" x-data="{
                    init() {
                        if (typeof Chart === 'undefined') return;
                
                        new Chart(this.$refs.canvas, {
                            type: 'bar',
                            data: {
                                labels: ['Produk Hukum', 'Penyusunan Produk Hukum', 'Rincian Data Dukung', 'Pejabat Berwenang'],
                                datasets: [{
                                    label: 'Total Data',
                                    data: [{{ $countKeputusan }}, {{ $countDataDukung }}, {{ $countDetails }}, {{ $countPejabat }}],
                                    backgroundColor: [
                                        'rgba(234, 179, 8, 0.7)',
                                        'rgba(79, 70, 229, 0.7)',
                                        'rgba(16, 185, 129, 0.7)',
                                        'rgba(244, 63, 94, 0.7)'
                                    ],
                                    hoverBackgroundColor: [
                                        '#eab308', '#4f46e5', '#10b981', '#f43f5e'
                                    ],
                                    borderRadius: 10,
                                    barPercentage: 0.6,
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false },
                                    tooltip: {
                                        padding: 12,
                                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                        titleFont: { size: 14, weight: 'bold' },
                                        cornerRadius: 8
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: { stepSize: 1 },
                                        grid: { borderDash: [5, 5], color: 'rgba(156, 163, 175, 0.1)' }
                                    },
                                    x: { grid: { display: false } }
                                }
                            }
                        });
                    }
                }">
                    <canvas x-ref="canvas"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
