<?php

use App\Models\BodyMetric;
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;

new #[Title('Add Body Metric')] class extends Component {
    use Toast;

    #[Validate('required|date|before_or_equal:today')]
    public string $measurement_date = '';

    #[Validate('required|numeric|min:20|max:300')]
    public string $weight = '';

    #[Validate('required|numeric|min:0.5|max:3')]
    public string $height = '';

    #[Validate('nullable|string|max:500')]
    public string $notes = '';

    /**
     * Montar el componente
     */
    public function mount()
    {
        // Fecha actual por defecto
        $this->measurement_date = now()->format('Y-m-d');

        // Cargar última medición para sugerir la altura
        $lastMetric = BodyMetric::where('user_id', Auth::id())->latest('measurement_date')->first();

        if ($lastMetric) {
            $this->height = (string) $lastMetric->height;
        }
    }

    /**
     * Guardar la nueva métrica corporal
     */
    public function save()
    {
        $this->validate();

        try {
            $weight = (float) $this->weight;
            $height = (float) $this->height;

            // Calcular BMI
            $bmi = null;
            if ($weight > 0 && $height > 0) {
                $bmi = round($weight / ($height * $height), 2);
            }

            // Crear la métrica
            BodyMetric::create([
                'user_id' => Auth::id(),
                'measurement_date' => $this->measurement_date,
                'weight' => $weight,
                'height' => $height,
                'bmi' => $bmi,
                'notes' => $this->notes ?: null,
            ]);

            // Notificar éxito
            $this->success(__('Measurement added successfully!'));

            // Redirigir al dashboard
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            // Notificar error
            $this->error(__('An error occurred while saving the measurement.'));
        }
    }
}; ?>

<div>
    <!-- HEADER -->
    <x-header title="{{ __('Add Body Metric') }}" separator>
        <x-slot:actions>
            <x-button link="{{ route('dashboard') }}" label="{{ __('Cancel') }}" icon="o-x-mark" />
        </x-slot:actions>
    </x-header>

    @php
        $breadcrumbs = [
            [
                'label' => __('Dashboard'),
                'link' => '/dashboard',
                'icon' => 'o-home',
            ],
            [
                'label' => __('Body Metrics'),
                'link' => route('body-metrics.create'),
                'icon' => 'o-heart',
            ],
        ];
    @endphp

    <!-- BREADCRUMBS -->
    <x-breadcrumbs :items="$breadcrumbs" class="mb-4" />

    <div>
        <x-form wire:submit="save">
            <x-card title="{{ __('Measurement Information') }}" shadow>
                <div class="grid md:grid-cols-2 gap-4">
                    <!-- Fecha de Medición -->
                    <div class="md:col-span-2">
                        <x-input wire:model="measurement_date" label="{{ __('Measurement Date') }}" icon="o-calendar"
                            type="date" hint="{{ __('When was this measurement taken?') }}" required />
                    </div>

                    <!-- Peso -->
                    <div>
                        <x-input wire:model="weight" label="{{ __('Weight') }}" icon="o-scale" type="number"
                            step="0.1" suffix="kg" placeholder="70.5"
                            hint="{{ __('Your current weight in kilograms') }}" required />
                    </div>

                    <!-- Altura -->
                    <div>
                        <x-input wire:model="height" label="{{ __('Height') }}" icon="o-arrow-up" type="number"
                            step="0.01" suffix="m" placeholder="1.75" hint="{{ __('Your height in meters') }}"
                            required />
                    </div>

                    <!-- Notas -->
                    <div class="md:col-span-2">
                        <x-textarea wire:model="notes" label="{{ __('Notes') }}" icon="o-pencil"
                            placeholder="{{ __('Add any relevant notes about this measurement...') }}"
                            hint="{{ __('Optional: diet changes, training notes, etc.') }}" rows="4" />
                    </div>
                </div>
            </x-card>

            <!-- Información Adicional -->
            <x-card title="{{ __('Helpful Tips') }}" class="mt-6" shadow>
                <div class="grid md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <div class="flex items-start gap-2">
                            <x-icon name="o-light-bulb" class="w-5 h-5 text-warning shrink-0 mt-0.5" />
                            <div>
                                <strong class="block mb-1">{{ __('Best time to measure') }}</strong>
                                <p class="text-gray-600">
                                    {{ __('Take measurements in the morning, before breakfast, for consistent results.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-start gap-2">
                            <x-icon name="o-clock" class="w-5 h-5 text-info shrink-0 mt-0.5" />
                            <div>
                                <strong class="block mb-1">{{ __('Frequency') }}</strong>
                                <p class="text-gray-600">
                                    {{ __('Measure yourself weekly or bi-weekly to track progress without obsessing.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-start gap-2">
                            <x-icon name="o-scale" class="w-5 h-5 text-success shrink-0 mt-0.5" />
                            <div>
                                <strong class="block mb-1">{{ __('Consistency') }}</strong>
                                <p class="text-gray-600">
                                    {{ __('Use the same scale and wear similar clothing for accurate tracking.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-start gap-2">
                            <x-icon name="o-chart-bar" class="w-5 h-5 text-primary shrink-0 mt-0.5" />
                            <div>
                                <strong class="block mb-1">{{ __('Track trends') }}</strong>
                                <p class="text-gray-600">
                                    {{ __('Focus on long-term trends rather than day-to-day fluctuations.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>

            <!-- Botones de Acción -->
            <div class="flex justify-end gap-3 mt-6">
                <x-button link="{{ route('dashboard') }}" label="{{ __('Cancel') }}" icon="o-x-mark" />

                <x-button type="submit" label="{{ __('Save Measurement') }}" icon="o-check" class="btn-primary"
                    spinner="save" />
            </div>
        </x-form>
    </div>
</div>
