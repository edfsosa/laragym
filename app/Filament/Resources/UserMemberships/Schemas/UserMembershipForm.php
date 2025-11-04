<?php

namespace App\Filament\Resources\UserMemberships\Schemas;

use App\Models\Membership;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class UserMembershipForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label(__('Member'))
                    ->options(fn() => User::role('member')->pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->required(),
                Select::make('membership_id')
                    ->label(__('Membership'))
                    ->relationship('membership', 'name')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn(Set $set, Get $get) => self::recalcEndAt($set, $get)),
                DatePicker::make('start_at')
                    ->label(__('Start at'))
                    ->displayFormat('d/m/Y')
                    ->closeOnDateSelection()
                    ->native(false)
                    ->default(now())
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn(Set $set, Get $get) => self::recalcEndAt($set, $get)),
                DatePicker::make('end_at')
                    ->label(__('End at'))
                    ->displayFormat('d/m/Y')
                    ->closeOnDateSelection()
                    ->native(false)
                    ->disabled()          // que no lo editen manualmente
                    ->dehydrated(true)    // pero que se guarde igual
                    ->required(),
                Select::make('status')
                    ->label(__('Status'))
                    ->options([
                        'active' => __('Active'),
                        'expired' => __('Expired'),
                        'cancelled' => __('Cancelled'),
                    ])
                    ->default('active')
                    ->native(false)
                    ->hiddenOn('create')
                    ->required(),   
            ]);
    }

    private static function recalcEndAt(Set $set, Get $get): void
    {
        $membershipId = $get('membership_id');
        $startAt      = $get('start_at');

        if (! $membershipId || ! $startAt) {
            $set('end_at', null);
            return;
        }

        $days = Membership::whereKey($membershipId)->value('duration_days') ?? 0;

        $set(
            'end_at',
            $days > 0
                ? Carbon::parse($startAt)->startOfDay()->addDays($days)
                : null
        );
    }
}
