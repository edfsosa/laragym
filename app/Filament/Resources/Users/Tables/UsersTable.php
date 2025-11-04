<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('personalData.avatar')
                    ->label(__('Avatar'))
                    ->disk('public')
                    ->circular(),
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('roles.name')
                    ->label(__('Role'))
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'Admin' => __('Administrator'),
                        'Trainer' => __('Trainer'),
                        'Member' => __('Member'),
                        default => __('Unknown'),
                    })
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('Status'))
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
                        'inactive' => __('Inactive'),
                        'suspended' => __('Suspended'),
                    ])
                    ->multiple()
                    ->native(false),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('reset-password')
                    ->label(__('Reset Password'))
                    ->icon('heroicon-o-key')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function (User $record) {
                        $newPassword = Str::random(10);

                        $record->update([
                            'password' => Hash::make($newPassword),
                        ]);

                        Notification::make()
                            ->title(__('Password Reset Successful'))
                            ->body(__('The new password is:') . ' <code>' . $newPassword . '</code>')
                            ->persistent()
                            ->success()
                            ->send();
                    })
                    ->modalHeading(__('Are you sure?'))
                    ->modalDescription(__('This action will reset the user\'s password and notify you with the new password.'))
                    ->modalSubmitActionLabel(__('Reset'))
                    ->visible(fn($record) => $record->hasRole(['Member', 'Trainer'])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
