@php
    $headers = [
        ['key' => 'id', 'label' => '#'],
        ['key' => 'routine.name', 'label' => __('Name')],
        ['key' => 'assignedBy.name', 'label' => __('Assigned by')],
        ['key' => 'assigned_at', 'label' => __('Assigned at')],
        ['key' => 'completed_at', 'label' => __('Completed at')],
        ['key' => 'status_translated', 'label' => __('Status')],
    ];
@endphp

<x-table :headers="$headers" :rows="$routines" striped with-pagination />
