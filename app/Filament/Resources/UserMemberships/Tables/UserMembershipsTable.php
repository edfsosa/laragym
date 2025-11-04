<?php

namespace App\Filament\Resources\UserMemberships\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UserMembershipsTable
{
    public static function configure(Table $table): Table
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
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
