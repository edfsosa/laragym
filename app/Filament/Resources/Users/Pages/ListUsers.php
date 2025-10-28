<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(__('All'))
                ->badge(User::count()),
            'admins' => Tab::make(__('Admins'))
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas('roles', fn($q) => $q->where('name', 'Admin')))
                ->badge(User::query()->whereHas('roles', fn($q) => $q->where('name', 'Admin'))->count()),
            'trainers' => Tab::make(__('Trainers'))
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas('roles', fn($q) => $q->where('name', 'Trainer')))
                ->badge(User::query()->whereHas('roles', fn($q) => $q->where('name', 'Trainer'))->count()),
            'members' => Tab::make(__('Members'))
                ->modifyQueryUsing(fn(Builder $query) => $query->whereHas('roles', fn($q) => $q->where('name', 'Member')))
                ->badge(User::query()->whereHas('roles', fn($q) => $q->where('name', 'Member'))->count()),
        ];
    }
}
