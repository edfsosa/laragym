<?php

namespace App\Filament\Resources\Routines\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
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
                    ->label(__('Duration (minutes)'))
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
                    ->label(__('Muscle group'))
                    ->formatStateUsing(fn(?string $state): string => match ($state) {
                        'full_body' => __('Full body'),
                        'upper_body' => __('Upper body'),
                        'lower_body' => __('Lower body'),
                        'core' => __('Core'),
                        default => $state ?? __('N/A'),
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
                SelectFilter::make('level')
                    ->label(__('Level'))
                    ->options([
                        'beginner' => __('Beginner'),
                        'intermediate' => __('Intermediate'),
                        'advanced' => __('Advanced'),
                    ])
                    ->multiple()
                    ->native(false),
                SelectFilter::make('type')
                    ->label(__('Type'))
                    ->options([
                        'strength' => __('Strength'),
                        'cardio' => __('Cardio'),
                        'flexibility' => __('Flexibility'),
                        'balance' => __('Balance'),
                    ])
                    ->multiple()
                    ->native(false),
                SelectFilter::make('muscle_group')
                    ->label(__('Muscle group'))
                    ->options([
                        'full_body' => __('Full body'),
                        'upper_body' => __('Upper body'),
                        'lower_body' => __('Lower body'),
                        'core' => __('Core'),
                    ])
                    ->multiple()
                    ->native(false),
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
