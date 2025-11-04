<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class UserAchievementsRelationManager extends RelationManager
{
    protected static string $relationship = 'userAchievements';
    protected static ?string $modelLabel = 'logro';
    protected static ?string $pluralModelLabel = 'logros';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('achievement_id')
                    ->label(__('Achievement'))
                    ->relationship('achievement', 'name')
                    ->preload()
                    ->native(false)
                    ->required(),
                DateTimePicker::make('unlocked_at')
                    ->label(__('Unlocked at'))
                    ->default(now())
                    ->native(false)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('achievement.name')
                    ->label(__('Achievement'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('unlocked_at')
                    ->label(__('Unlocked at'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
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
        return __('Achievements');
    }
}
