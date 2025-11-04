<?php

namespace App\Filament\Resources\Achievements;

use App\Filament\Resources\Achievements\Pages\ManageAchievements;
use App\Models\Achievement;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class AchievementResource extends Resource
{
    protected static ?string $model = Achievement::class;
    protected static ?string $navigationLabel = 'Logros';
    protected static ?string $pluralModelLabel = 'logros';
    protected static ?string $modelLabel = 'logro';
    protected static string | UnitEnum | null $navigationGroup = 'Usuarios';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentCheck;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('icon')
                    ->label(__('Icon'))
                    ->maxLength(255)
                    ->nullable(),
                TextInput::make('name')
                    ->label(__('Name'))
                    ->maxLength(255)
                    ->required(),
                Textarea::make('description')
                    ->label(__('Description'))
                    ->rows(3)
                    ->columnSpanFull()
                    ->maxLength(1000)
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('icon')
                    ->label(__('Icon'))
                    ->sortable(),
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label(__('Description'))
                    ->limit(50)
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
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
            'index' => ManageAchievements::route('/'),
        ];
    }
}
