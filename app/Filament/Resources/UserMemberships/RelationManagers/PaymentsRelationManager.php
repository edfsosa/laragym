<?php

namespace App\Filament\Resources\UserMemberships\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';
    protected static ?string $modelLabel = 'pago';
    protected static ?string $pluralModelLabel = 'pagos';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('amount')
                    ->label(__('Amount'))
                    ->integer()
                    ->prefix('Gs. ')
                    ->minValue(0)
                    ->maxLength(10)
                    ->step(1)
                    ->default(fn() => $this->ownerRecord->membership->price ?? 0)
                    ->required(),
                Select::make('method')
                    ->label(__('Method'))
                    ->options([
                        'cash' => __('Cash'),
                        'credit_card' => __('Credit card'),
                        'debit_card' => __('Debit card'),
                        'bank_transfer' => __('Bank transfer'),
                        'qr_code' => __('QR code'),
                        'other' => __('Other'),
                    ])
                    ->native(false)
                    ->default('cash')
                    ->required(),
                Select::make('status')
                    ->label(__('Status'))
                    ->options([
                        'paid' => __('Paid'),
                        'pending' => __('Pending'),
                        'failed' => __('Failed'),
                    ])
                    ->native(false)
                    ->default('pending')
                    ->required(),
                DateTimePicker::make('paid_at')
                    ->label(__('Payment date'))
                    ->displayFormat('d/m/Y H:i')
                    ->native(false)
                    ->default(now())
                    ->nullable(),
                TextInput::make('transaction_reference')
                    ->label(__('Transaction reference'))
                    ->maxLength(255)
                    ->nullable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('userMembership.membership.name')
                    ->label(__('Membership'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('amount')
                    ->label(__('Amount'))
                    ->money('PYG', true)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('method')
                    ->label(__('Method'))
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'cash' => __('Cash'),
                        'credit_card' => __('Credit card'),
                        'debit_card' => __('Debit card'),
                        'bank_transfer' => __('Bank transfer'),
                        'qr_code' => __('QR code'),
                        'other' => __('Other'),
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        'failed' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'paid' => __('Paid'),
                        'pending' => __('Pending'),
                        'failed' => __('Failed'),
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('paid_at')
                    ->label(__('Payment date'))
                    ->dateTime('d/m/Y H:i')
                    ->searchable()
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
                        'paid' => __('Paid'),
                        'pending' => __('Pending'),
                        'failed' => __('Failed'),
                    ])
                    ->multiple()
                    ->native(false),
                SelectFilter::make('method')
                    ->label(__('Method'))
                    ->options([
                        'cash' => __('Cash'),
                        'credit_card' => __('Credit card'),
                        'debit_card' => __('Debit card'),
                        'bank_transfer' => __('Bank transfer'),
                        'qr_code' => __('QR code'),
                        'other' => __('Other'),
                    ])
                    ->multiple()
                    ->native(false),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label(__('Add')),
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
        return __('Payments');
    }
}
