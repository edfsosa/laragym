<?php

namespace App\Filament\Widgets;

use App\Models\Equipment;
use App\Models\User;
use App\Models\UserMembership;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $activeUsersWithMemberRole = User::where('status', 'active')
            ->whereHas('roles', function ($query) {
                $query->where('name', 'Member');
            })
            ->count();

        $activeMemberships = UserMembership::where('status', 'active')->count();

        $availableEquipments = Equipment::where('status', 'available')->count();

        return [
            Stat::make(__('Active members'), $activeUsersWithMemberRole)
                ->description(__('Users with active status and member role'))
                ->color('primary'),
            Stat::make(__('Active memberships'), $activeMemberships)
                ->description(__('Total number of active memberships'))
                ->color('primary'),
            Stat::make(__('Available equipments'), $availableEquipments)
                ->description(__('Total number of available equipments'))
                ->color('primary'),
        ];
    }
}
