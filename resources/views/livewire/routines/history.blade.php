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
    <x-header title="{{ __('Routines History') }}" separator>
        <x-slot:actions>
            <x-button link="/routines" label="{{ __('Cancel') }}" icon="o-x-mark" />
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
                'label' => __('Routines'),
                'link' => '/routines',
                'icon' => 'o-clipboard-document-list',
            ],
            [
                'label' => __('History'),
                'icon' => 'o-clock',
            ],
        ];
    @endphp
    <!-- BREADCRUMBS -->
    <x-breadcrumbs :items="$breadcrumbs" class="mb-4" />

    {{--  LIST  --}}
    <x-routines.history-table :routines="$routines" />
</div>
