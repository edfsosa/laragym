<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;

class MembershipsRelationManager extends RelationManager
{
    protected static string $relationship = 'memberships';
    protected static ?string $modelLabel = 'membresía';
    protected static ?string $pluralModelLabel = 'membresías';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                    ->label(__('Start at'))
                    ->displayFormat('d/m/Y')
                    ->closeOnDateSelection()
                    ->native(false)
                    ->default(now())
                    ->required()
                    ->live()
                    ->afterStateUpdated(fn(Set $set, Get $get) => self::recalcEndAt($set, $get)),
                DatePicker::make('end_at')
                    ->label(__('End at'))
                    ->displayFormat('d/m/Y')
                    ->closeOnDateSelection()
                    ->native(false)
                    ->disabled()
                    ->dehydrated(true)
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

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('membership.name')
                    ->label(__('Membership'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('start_at')
                    ->label(__('Start at'))
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('end_at')
                    ->label(__('End at'))
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
                SelectFilter::make('membership_id')
                    ->label(__('Membership'))
                    ->relationship('membership', 'name')
                    ->multiple()
                    ->native(false),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label(__('Add'))
                    ->visible(function (RelationManager $livewire) {
                        $user = $livewire->getOwnerRecord();
                        return !$user->memberships()->where('status', 'active')->exists();
                    }),
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

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Memberships');
    }
}
