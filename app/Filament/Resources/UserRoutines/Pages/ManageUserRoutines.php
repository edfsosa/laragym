<?php

namespace App\Filament\Resources\UserRoutines\Pages;

use App\Filament\Resources\UserRoutines\UserRoutineResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth;

class ManageUserRoutines extends ManageRecords
{
    protected static string $resource = UserRoutineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('Assign Routine'))
                ->mutateDataUsing(function (array $data): array {
                    $data['assigned_by'] = Auth::id();
                    $data['assigned_at'] = now();
                    return $data;
                }),
        ];
    }
}
