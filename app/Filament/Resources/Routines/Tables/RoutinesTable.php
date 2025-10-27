<?php

namespace App\Filament\Resources\Routines\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RoutinesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('level')
                    ->label(__('Level'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'beginner' => 'success',
                        'intermediate' => 'warning',
                        'advanced' => 'danger',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'beginner' => __('Beginner'),
                        'intermediate' => __('Intermediate'),
                        'advanced' => __('Advanced'),
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('duration_minutes')
                    ->label(__('Duration (Minutes)'))
                    ->numeric()
                    ->sortable(),
                TextColumn::make('type')
                    ->label(__('Type'))
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'strength' => __('Strength'),
                        'cardio' => __('Cardio'),
                        'flexibility' => __('Flexibility'),
                        'balance' => __('Balance'),
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('muscle_group')
                    ->label(__('Muscle Group'))
                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                        'full_body' => __('Full body'),
                        'upper_body' => __('Upper body'),
                        'lower_body' => __('Lower body'),
                        'core' => __('Core'),
                        default => $state ?? __('N/A'),
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('Created'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('Updated'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
