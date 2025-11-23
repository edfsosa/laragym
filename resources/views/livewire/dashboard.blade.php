<?php

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserRoutine;
use App\Models\UserRoutineExerciseLog;
use App\Models\BodyMetric;
use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;

new #[Title('Dashboard')] class extends Component {
    public int $completedRoutines = 0;
    public int $exercisesDone = 0;
    public int $trainingDaysThisMonth = 0;

    // Body Metrics
    public ?float $currentWeight = null;
    public ?float $currentHeight = null;
    public ?float $currentBMI = null;
    public ?float $weightChange = null;
    public ?string $lastMeasurementDate = null;

    // Chart data
    public array $weightChart = [];

    /**
     * Montar el componente y cargar los datos iniciales.
     */
    public function mount()
    {
        $userId = auth()->id();

        // Estadísticas de Entrenamiento
        $this->completedRoutines = UserRoutine::where('user_id', $userId)->whereNotNull('completed_at')->count();

        $this->exercisesDone = UserRoutineExerciseLog::whereHas('userRoutine', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->where('status', 'completed')
            ->count();

        $this->trainingDaysThisMonth = UserRoutineExerciseLog::whereHas('userRoutine', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
            ->where('status', 'completed')
            ->whereMonth('completed_at', now()->month)
            ->whereYear('completed_at', now()->year)
            ->distinct()
            ->count(DB::raw('DATE(completed_at)'));

        // Métricas Corporales
        $this->loadBodyMetrics($userId);

        // Cargar datos del gráfico
        $this->loadWeightChart($userId);
    }

    /**
     * Cargar las métricas corporales actuales del usuario.
     */
    private function loadBodyMetrics($userId)
    {
        // Última medición
        $latestMetric = BodyMetric::where('user_id', $userId)->latest('measurement_date')->first();

        // Asignar valores actuales
        if ($latestMetric) {
            $this->currentWeight = $latestMetric->weight;
            $this->currentHeight = $latestMetric->height;
            $this->currentBMI = $latestMetric->bmi;
            $this->lastMeasurementDate = $latestMetric->measurement_date;

            // Calcular cambio de peso (comparar con la medición anterior)
            $previousMetric = BodyMetric::where('user_id', $userId)->where('measurement_date', '<', $latestMetric->measurement_date)->latest('measurement_date')->first();

            // Calcular la diferencia de peso
            if ($previousMetric && $previousMetric->weight) {
                $this->weightChange = round($latestMetric->weight - $previousMetric->weight, 1);
            }
        }
    }

    /**
     * Cargar los datos del gráfico de peso.
     */
    private function loadWeightChart($userId)
    {
        // Obtener las últimas 10 métricas para el gráfico
        $metrics = BodyMetric::where('user_id', $userId)->latest('measurement_date')->take(10)->get()->reverse()->values();

        // Configurar los datos del gráfico si hay suficientes métricas
        if ($metrics->count() > 1) {
            $this->weightChart = [
                'type' => 'line',
                'data' => [
                    'labels' => $metrics->map(fn($m) => \Carbon\Carbon::parse($m->measurement_date)->format('M d'))->values()->toArray(),
                    'datasets' => [
                        [
                            'label' => __('Weight (kg)'),
                            'data' => $metrics->pluck('weight')->values()->toArray(),
                            'borderColor' => 'rgb(59, 130, 246)',
                            'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                            'tension' => 0.3,
                            'fill' => true,
                        ],
                    ],
                ],
                'options' => [
                    'responsive' => true,
                    'maintainAspectRatio' => false,
                    'plugins' => [
                        'legend' => [
                            'display' => false,
                        ],
                    ],
                    'scales' => [
                        'y' => [
                            'beginAtZero' => false,
                        ],
                    ],
                ],
            ];
        }
    }

    #[Computed]
    public function recentMetrics()
    {
        return BodyMetric::where('user_id', auth()->id())
            ->latest('measurement_date')
            ->take(5)
            ->get();
    }

    #[Computed]
    public function bmiCategory()
    {
        if (!$this->currentBMI) {
            return null;
        }

        // Determinar la categoría de IMC
        return match (true) {
            $this->currentBMI < 18.5 => ['label' => __('Underweight'), 'color' => 'text-warning'],
            $this->currentBMI < 25 => ['label' => __('Normal'), 'color' => 'text-success'],
            $this->currentBMI < 30 => ['label' => __('Overweight'), 'color' => 'text-warning'],
            default => ['label' => __('Obese'), 'color' => 'text-error'],
        };
    }
}; ?>

<div>
    <!-- HEADER -->
    <x-header title="{{ __('Dashboard') }}" subtitle="{{ __('Welcome back') }}, {{ auth()->user()->name }}!" separator />

    <!-- ESTADÍSTICAS DE ENTRENAMIENTO -->
    <div class="mb-6">
        <h2 class="text-lg font-semibold mb-4">{{ __('Training Statistics') }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-stat title="{{ __('Routines completed') }}" value="{{ $completedRoutines }}" icon="o-check-circle"
                color="text-primary" tooltip="{{ __('Total completed routines') }}" />

            <x-stat title="{{ __('Exercises done') }}" value="{{ $exercisesDone }}" icon="o-check" color="text-success"
                tooltip="{{ __('Total exercises completed') }}" />

            <x-stat title="{{ __('Training days this month') }}" value="{{ $trainingDaysThisMonth }}"
                icon="o-calendar" color="text-info" tooltip="{{ __('Days trained in') }} {{ now()->format('F') }}" />
        </div>
    </div>

    <!-- MÉTRICAS CORPORALES -->
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">{{ __('Body Metrics') }}</h2>
            <x-button link="{{ route('body-metrics.create') }}" label="{{ __('Add Measurement') }}" icon="o-plus"
                class="btn-sm btn-primary" />
        </div>

        @if ($currentWeight || $currentHeight || $currentBMI)
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                <!-- Peso Actual -->
                <x-stat title="{{ __('Current Weight') }}"
                    value="{{ $currentWeight ? number_format($currentWeight, 1) . ' kg' : __('N/A') }}" icon="o-scale"
                    color="text-primary">
                    @if ($weightChange)
                        <x-slot:description>
                            <span class="{{ $weightChange > 0 ? 'text-error' : 'text-success' }}">
                                {{ $weightChange > 0 ? '+' : '' }}{{ $weightChange }} kg
                            </span>
                            {{ __('vs last') }}
                        </x-slot:description>
                    @endif
                </x-stat>

                <!-- Altura Actual -->
                <x-stat title="{{ __('Height') }}"
                    value="{{ $currentHeight ? number_format($currentHeight, 2) . ' m' : __('N/A') }}"
                    icon="o-arrow-up" color="text-info" />

                <!-- IMC Actual -->
                <x-stat title="{{ __('BMI') }}"
                    value="{{ $currentBMI ? number_format($currentBMI, 1) : __('N/A') }}" icon="o-chart-bar"
                    :color="$this->bmiCategory['color'] ?? 'text-gray-500'">
                    @if ($this->bmiCategory)
                        <x-slot:description>
                            {{ $this->bmiCategory['label'] }}
                        </x-slot:description>
                    @endif
                </x-stat>

                <!-- Última Medición -->
                <x-stat title="{{ __('Last Measurement') }}"
                    value="{{ $lastMeasurementDate ? \Carbon\Carbon::parse($lastMeasurementDate)->diffForHumans() : __('N/A') }}"
                    icon="o-clock" color="text-warning" />
            </div>

            <!-- HISTORIAL DE MÉTRICAS -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <!-- Tabla de Mediciones Recientes -->
                <x-card title="{{ __('Recent Measurements') }}" shadow>
                    @if ($this->recentMetrics->count() > 0)
                        <x-table :headers="[
                            ['key' => 'date', 'label' => __('Date')],
                            ['key' => 'weight', 'label' => __('Weight')],
                            ['key' => 'bmi', 'label' => __('BMI')],
                        ]" :rows="$this->recentMetrics" striped>
                            @scope('cell_date', $metric)
                                {{ \Carbon\Carbon::parse($metric->measurement_date)->format('d/m/Y') }}
                            @endscope

                            @scope('cell_weight', $metric)
                                {{ number_format($metric->weight, 1) }} kg
                            @endscope

                            @scope('cell_bmi', $metric)
                                <span class="font-semibold">{{ number_format($metric->bmi, 1) }}</span>
                            @endscope
                        </x-table>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <x-icon name="o-chart-bar" class="w-12 h-12 mx-auto mb-2 opacity-50" />
                            <p>{{ __('No measurements yet') }}</p>
                        </div>
                    @endif
                </x-card>

                <!-- Gráfico de Tendencia de Peso -->
                <x-card title="{{ __('Weight Trend') }}" shadow>
                    @if (!empty($weightChart))
                        <div style="height: 250px;">
                            <x-chart wire:model="weightChart" />
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <x-icon name="o-chart-bar" class="w-12 h-12 mx-auto mb-2 opacity-50" />
                            <p>{{ __('Need at least 2 measurements to show trend') }}</p>
                        </div>
                    @endif
                </x-card>
            </div>
        @else
            <!-- Sin Métricas -->
            <x-card shadow>
                <div class="text-center py-12">
                    <x-icon name="o-scale" class="w-16 h-16 mx-auto mb-4 text-gray-400" />
                    <h3 class="text-lg font-semibold mb-2">{{ __('No body metrics recorded') }}</h3>
                    <p class="text-gray-500 mb-4">
                        {{ __('Start tracking your progress by adding your first measurement') }}</p>
                    <x-button link="{{ route('body-metrics.create') }}" label="{{ __('Add First Measurement') }}"
                        icon="o-plus" class="btn-primary" />
                </div>
            </x-card>
        @endif
    </div>
</div>
