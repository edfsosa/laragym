<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl p-4 md:p-6">

        {{-- 🔹 Bienvenida / Header --}}
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-2">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">👋 {{ __('Welcome back!') }}</h1>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Here’s an overview of your recent activity and progress.') }}
                </p>
            </div>
            <button
                class="mt-4 md:mt-0 px-4 py-2 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 transition">
                {{ __('View Reports') }}
            </button>
        </div>

        {{-- 🔹 Tarjetas resumen --}}
        <div class="grid gap-6 md:grid-cols-3">
            @foreach ($cards as $card)
                <div
                    class="group relative rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-6 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    {{-- Icono decorativo --}}
                    <div
                        class="absolute -top-3 -right-3 bg-indigo-600 dark:bg-indigo-500 text-white p-2 rounded-lg shadow-sm">
                        <x-heroicon-o-chart-bar class="w-5 h-5" />
                    </div>

                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        {{ $card['title'] }}
                    </h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                        {{ $card['description'] }}
                    </p>
                    <p class="text-3xl font-extrabold text-indigo-600 dark:text-indigo-400">
                        {{ $card['value'] }}
                    </p>
                </div>
            @endforeach
        </div>

        {{-- 🔹 Gráfica semanal --}}
        <div
            class="relative mt-6 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ __('Weekly Progress') }}
                </h3>
                <div class="flex gap-2 text-xs text-gray-500 dark:text-gray-400">
                    <span class="flex items-center gap-1"><span
                            class="w-3 h-3 rounded-full bg-indigo-500"></span>Calories</span>
                </div>
            </div>
            <canvas id="progressChart" height="100"></canvas>
        </div>

        {{-- 🔹 Script de Chart.js --}}
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('progressChart');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($progress['labels']),
                    datasets: [{
                        label: 'Calories burned',
                        data: @json($progress['values']),
                        borderWidth: 3,
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.15)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#6366f1',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1e1b4b',
                            titleColor: '#fff',
                            bodyColor: '#e0e7ff',
                            cornerRadius: 6,
                            padding: 10
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(156, 163, 175, 0.2)'
                            },
                            ticks: {
                                color: '#9ca3af'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#9ca3af'
                            }
                        }
                    }
                }
            });
        </script>
    </div>
</x-layouts.app>
