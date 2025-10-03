<?php

namespace App\Filament\Resources\MembershipTypes;

use App\Filament\Resources\MembershipTypes\Pages\ManageMembershipTypes;
use App\Models\MembershipType;
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

class MembershipTypeResource extends Resource
{
    protected static ?string $model = MembershipType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Membership Name')
                    ->required(),
                TextInput::make('price')
                    ->label('Price')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxLength(10)
                    ->step(1),
                TextInput::make('duration_days')
                    ->label('Duration (Days)')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxLength(3)
                    ->step(1),
                Toggle::make('is_active')
                    ->label('Is Active')
                    ->inline(false)
                    ->default(true)
                    ->hiddenOn('create')
                    ->required(),
                Textarea::make('description')
                    ->label('Description')
                    ->columnSpanFull()
                    ->rows(3)
                    ->maxLength(1000)
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Membership Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Price')
                    ->money('PYG', true)
                    ->sortable(),
                TextColumn::make('duration_days')
                    ->label('Duration (Days)')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Is Active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime()
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
            'index' => ManageMembershipTypes::route('/'),
        ];
    }
}
