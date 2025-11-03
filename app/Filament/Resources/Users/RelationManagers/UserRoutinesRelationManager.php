<?php

namespace App\Filament\Resources\Users\RelationManagers;

use App\Models\UserRoutine;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserRoutinesRelationManager extends RelationManager
{
    protected static string $relationship = 'userRoutines';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitle(fn(UserRoutine $record): string => "{$record->routine->name}")
            ->columns([
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
                SelectFilter::make('routine_id')
                    ->label(__('Routine'))
                    ->relationship('routine', 'name')
                    ->multiple()
                    ->native(false),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label(__('Assign'))
                    ->mutateDataUsing(function (array $data): array {
                        $data['assigned_by'] = Auth::id();
                        $data['assigned_at'] = now();
                        return $data;
                    }),
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

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Routines');
    }
}
