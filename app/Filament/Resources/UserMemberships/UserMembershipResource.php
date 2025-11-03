<?php

namespace App\Filament\Resources\UserMemberships;

use App\Filament\Resources\UserMemberships\Pages\ManageUserMemberships;
use App\Models\Membership;
use App\Models\User;
use App\Models\UserMembership;
use BackedEnum;
use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class UserMembershipResource extends Resource
{
    protected static ?string $model = UserMembership::class;
    protected static ?string $navigationLabel = 'Membresías';
    protected static ?string $pluralModelLabel = 'membresías';
    protected static ?string $modelLabel = 'membresía';
    protected static ?string $slug = 'memberships';
    protected static string | UnitEnum | null $navigationGroup = 'Membresías';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedIdentification;

    public static function form(Schema $schema): Schema
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
                    ->label(__('Start At'))
                    ->displayFormat('d/m/Y')
                    ->closeOnDateSelection()
                    ->native(false)
                    ->default(now())
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn(Set $set, Get $get) => self::recalcEndAt($set, $get)),
                DatePicker::make('end_at')
                    ->label(__('End At'))
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('Member'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('membership.name')
                    ->label(__('Membership'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('start_at')
                    ->label(__('Start At'))
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('end_at')
                    ->label(__('End At'))
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'active' => 'success',
                        'expired' => 'warning',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'active' => __('Active'),
                        'expired' => __('Expired'),
                        'cancelled' => __('Cancelled'),
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('Updated at'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('Status'))
                    ->options([
                        'active' => __('Active'),
                        'expired' => __('Expired'),
                        'cancelled' => __('Cancelled'),
                    ])
                    ->multiple()
                    ->native(false),
                SelectFilter::make('user_id')
                    ->label(__('Member'))
                    ->options(fn() => User::role('member')->pluck('name', 'id'))
                    ->multiple()
                    ->native(false),
                SelectFilter::make('membership_id')
                    ->label(__('Membership'))
                    ->relationship('membership', 'name')
                    ->multiple()
                    ->native(false),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageUserMemberships::route('/'),
        ];
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
