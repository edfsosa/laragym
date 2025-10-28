<?php

namespace App\Filament\Resources\Memberships;

use App\Filament\Resources\Memberships\Pages\ManageMemberships;
use App\Models\Membership;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MembershipResource extends Resource
{
    protected static ?string $model = Membership::class;
    protected static ?string $navigationLabel = 'Membresías';
    protected static ?string $pluralModelLabel = 'membresías';
    protected static ?string $modelLabel = 'membresía';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Identification;
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->required(),
                TextInput::make('price')
                    ->label(__('Price'))
                    ->required()
                    ->integer()
                    ->minValue(0)
                    ->maxLength(10)
                    ->step(1)
                    ->prefix('PYG '),
                TextInput::make('duration_days')
                    ->label(__('Duration (days)'))
                    ->required()
                    ->integer()
                    ->minValue(1)
                    ->maxValue(365)
                    ->step(1)
                    ->helperText(__('Duration of the membership in days.')),
                Textarea::make('description')
                    ->label(__('Description'))
                    ->columnSpanFull()
                    ->rows(3)
                    ->nullable(),
                Toggle::make('is_active')
                    ->label(__('Is Active'))
                    ->required(),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(),
                TextColumn::make('price')
                    ->label(__('Price'))
                    ->money('PYG', true)
                    ->sortable(),
                TextColumn::make('duration_days')
                    ->label(__('Duration (days)'))
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label(__('Is Active'))
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            'index' => ManageMemberships::route('/'),
        ];
    }
}
