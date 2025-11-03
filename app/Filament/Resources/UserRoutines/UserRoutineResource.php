<?php

namespace App\Filament\Resources\UserRoutines;

use App\Filament\Resources\UserRoutines\Pages\ManageUserRoutines;
use App\Models\User;
use App\Models\UserRoutine;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use UnitEnum;

class UserRoutineResource extends Resource
{
    protected static ?string $model = UserRoutine::class;
    protected static ?string $navigationLabel = 'Rutinas asignadas';
    protected static ?string $pluralModelLabel = 'rutinas asignadas';
    protected static ?string $modelLabel = 'rutina asignada';
    protected static ?string $slug = 'assigned-routines';
    protected static string | UnitEnum | null $navigationGroup = 'Entrenamiento';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCheckBadge;

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
                Select::make('routine_id')
                    ->label(__('Routine'))
                    ->relationship('routine', 'name')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->required(),
                Select::make('status')
                    ->label(__('Status'))
                    ->options([
                        'assigned' => __('Assigned'),
                        'in_progress' => __('In progress'),
                        'paused' => __('Paused'),
                        'completed' => __('Completed'),
                        'cancelled' => __('Cancelled'),
                    ])
                    ->default('assigned')
                    ->native(false)
                    ->required(),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('Member'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('routine.name')
                    ->label(__('Routine'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'assigned' => 'primary',
                        'in_progress' => 'warning',
                        'paused' => 'gray',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'assigned' => __('Assigned'),
                        'in_progress' => __('In progress'),
                        'paused' => __('Paused'),
                        'completed' => __('Completed'),
                        'cancelled' => __('Cancelled'),
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('assignedBy.name')
                    ->label(__('Assigned by'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('assigned_at')
                    ->label(__('Assigned at'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('Status'))
                    ->options([
                        'assigned' => __('Assigned'),
                        'in_progress' => __('In progress'),
                        'paused' => __('Paused'),
                        'completed' => __('Completed'),
                        'cancelled' => __('Cancelled'),
                    ])
                    ->multiple()
                    ->native(false),
                SelectFilter::make('user_id')
                    ->label(__('Member'))
                    ->options(fn() => User::role('member')->pluck('name', 'id'))
                    ->multiple()
                    ->native(false),
                SelectFilter::make('routine_id')
                    ->label(__('Routine'))
                    ->relationship('routine', 'name')
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
            'index' => ManageUserRoutines::route('/'),
        ];
    }
}
