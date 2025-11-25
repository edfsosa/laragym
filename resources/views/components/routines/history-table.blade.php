@php
    $headers = [
        ['key' => 'id', 'label' => '#'],
        ['key' => 'routine.name', 'label' => __('Name')],
        ['key' => 'assignedBy.name', 'label' => __('Assigned by')],
        ['key' => 'assigned_at', 'label' => __('Assigned at'), 'format' => ['date', 'd/m/Y H:i']],
        ['key' => 'completed_at', 'label' => __('Completed at'), 'format' => ['date', 'd/m/Y H:i']],
        ['key' => 'exercise_logs_count', 'label' => __('Exercises')],
        ['key' => 'status_translated', 'label' => __('Status')],
    ];
@endphp

<x-table :headers="$headers" :rows="$routines" striped with-pagination />
