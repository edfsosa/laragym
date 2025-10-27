<?php

namespace App\Filament\Resources\Equipment\Tables;

use App\Models\Equipment;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class EquipmentTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label(__('Type'))
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'cardio' => __('Cardio'),
                        'strength' => __('Strength'),
                        'flexibility' => __('Flexibility'),
                        'balance' => __('Balance'),
                        'mobility' => __('Mobility'),
                        'other' => __('Other'),
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('serial_number')
                    ->label(__('Serial number'))
                    ->searchable(),
                TextColumn::make('brand')
                    ->label(__('Brand'))
                    ->searchable(),
                TextColumn::make('model')
                    ->label(__('Model'))
                    ->searchable(),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'available' => 'success',
                        'maintenance' => 'warning',
                        'out_of_order' => 'danger',
                        default => 'primary',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'available' => __('Available'),
                        'maintenance' => __('Maintenance'),
                        'out_of_order' => __('Out of order'),
                        default => $state,
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
                SelectFilter::make('type')
                    ->label(__('Type'))
                    ->options([
                        'cardio' => __('Cardio'),
                        'strength' => __('Strength'),
                        'flexibility' => __('Flexibility'),
                        'balance' => __('Balance'),
                        'mobility' => __('Mobility'),
                        'other' => __('Other'),
                    ])
                    ->multiple()
                    ->native(false),
                SelectFilter::make('status')
                    ->label(__('Status'))
                    ->options([
                        'available' => __('Available'),
                        'maintenance' => __('Maintenance'),
                        'out_of_order' => __('Out of order')
                    ])
                    ->multiple()
                    ->native(false),
            ])
            ->recordActions([
                Action::make('view_video')
                    ->label(__('View Video'))
                    ->icon(Heroicon::Eye)
                    ->color('secondary')
                    ->url(fn(Equipment $record): ?string => $record->video_url)
                    ->openUrlInNewTab()
                    ->hidden(fn(?Equipment $record): bool => !$record || !$record->video_url),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
