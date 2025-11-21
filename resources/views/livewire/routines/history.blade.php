<?php

use Livewire\WithPagination; 
use App\Models\UserRoutine;
use Illuminate\Pagination\LengthAwarePaginator; 
use Livewire\Volt\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\Title;


new #[Title('Routines History')] class extends Component {
    use Toast;
    use WithPagination;
    /**
     * Rutinas completadas por el usuario autenticado.
     */
    public function routines(): LengthAwarePaginator 
    {
        return UserRoutine::query()
            ->with(['user', 'routine', 'assignedBy'])
            ->withCount('exerciseLogs')
            ->where('user_id', auth()->id())
            ->where('status', 'completed')
            ->orderBy('completed_at', 'desc')
            ->paginate(10);
    }

    /**
     * Datos para la vista.
     */
    public function with(): array
    {
        return [
            'routines' => $this->routines(),
        ];
    }
}; ?>

<div>
    <!-- HEADER -->
    <x-header title="{{ __('Routines History') }}" separator />

    @php
        $breadcrumbs = [
            [
                'label' => __('Dashboard'),
                'link' => '/dashboard',
            ],
            [
                'label' => __('Routines'),
                'link' => '/routines',
            ],
            [
                'label' => __('History'),
            ],
        ];
    @endphp
    <!-- BREADCRUMBS -->
    <x-breadcrumbs :items="$breadcrumbs" class="mb-4" />

    {{-- ACTIONS --}}
    <div class="flex items-center justify-start mb-6 space-x-2">
        <x-routines.go-back-button />
    </div>

    {{--  LIST  --}}
    <x-routines.history-table :routines="$routines" />
</div>
