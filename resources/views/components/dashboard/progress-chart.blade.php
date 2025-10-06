<div
    class="relative mt-6 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 p-6 shadow-sm overflow-x-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white">
            {{ __('Weekly Progress') }}
        </h3>
        <div class="flex gap-2 text-xs text-gray-500 dark:text-gray-400">
            <span class="flex items-center gap-1">
                <span class="w-3 h-3 rounded-full bg-indigo-500"></span> {{ __('Calories') }}
            </span>
        </div>
    </div>

    {{-- Chart container --}}
    <div class="w-full overflow-x-auto">
        <canvas id="progressChart" class="w-full max-w-full" height="100" aria-label="Weekly calories chart"
            role="img"></canvas>
    </div>
</div>

{{-- Chart.js CDN --}}
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('progressChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($progress['labels']),
                    datasets: [{
                        label: '{{ __('Calories burned') }}',
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
                    maintainAspectRatio: false,
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
        });
    </script>
@endpush
