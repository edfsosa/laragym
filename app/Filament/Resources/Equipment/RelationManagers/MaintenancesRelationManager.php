<?php

namespace App\Filament\Resources\Equipment\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class MaintenancesRelationManager extends RelationManager
{
    protected static string $relationship = 'maintenances';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label(__('Title'))
                    ->required()
                    ->maxLength(255)
                    ->hint(__("E.g., 'Monthly maintenance'")),
                Select::make('type')
                    ->label(__('Type'))
                    ->options([
                        'preventive' => __('Preventive'),
                        'corrective' => __('Corrective'),
                    ])
                    ->native(false)
                    ->required(),
                Textarea::make('description')
                    ->label(__('Description'))
                    ->rows(4)
                    ->maxLength(65535)
                    ->nullable()
                    ->columnSpanFull(),
                Select::make('status')
                    ->label(__('Status'))
                    ->options([
                        'pending' => __('Pending'),
                        'in_progress' => __('In Progress'),
                        'completed' => __('Completed'),
                    ])
                    ->native(false)
                    ->default('pending')
                    ->hiddenOn('create')
                    ->required(),
                DateTimePicker::make('performed_at')
                    ->label(__('Performed At'))
                    ->displayFormat('d/m/Y H:i')
                    ->native(false)
                    ->nullable()
                    ->hiddenOn('create'),
                DateTimePicker::make('next_due_at')
                    ->label(__('Next Due At'))
                    ->displayFormat('d/m/Y H:i')
                    ->native(false)
                    ->nullable(),
                TextInput::make('cost')
                    ->label(__('Cost'))
                    ->prefix('Gs.')
                    ->integer()
                    ->minValue(0)
                    ->maxLength(12)
                    ->step(1)
                    ->nullable(),
                TextInput::make('vendor')
                    ->label(__('Vendor'))
                    ->maxLength(255)
                    ->nullable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label(__('Type'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'preventive' => 'primary',
                        'corrective' => 'warning',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'preventive' => __('Preventive'),
                        'corrective' => __('Corrective'),
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'in_progress' => 'primary',
                        'completed' => 'success',
                        default => 'secondary',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => __('Pending'),
                        'in_progress' => __('In Progress'),
                        'completed' => __('Completed'),
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('performed_at')
                    ->label(__('Performed At'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('next_due_at')
                    ->label(__('Next Due At'))
                    ->dateTime('d/m/Y H:i')
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
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label(__('Create'))
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
        return __('Maintenances');
    }
}
