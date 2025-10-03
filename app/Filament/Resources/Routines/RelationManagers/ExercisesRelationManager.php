<?php

namespace App\Filament\Resources\Routines\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExercisesRelationManager extends RelationManager
{
    protected static string $relationship = 'exercises';
    protected static ?string $recordTitleAttribute = 'exercise.name';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('exercise_id')
                    ->label('Exercise')
                    ->relationship('exercise', 'name')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->required(),
                TextInput::make('order')
                    ->label('Order')
                    ->numeric()
                    ->default(1)
                    ->minValue(1)
                    ->maxValue(20)
                    ->step(1)
                    ->required(),
                TextInput::make('sets')
                    ->label('Sets')
                    ->numeric()
                    ->default(3)
                    ->minValue(1)
                    ->maxValue(10)
                    ->step(1)
                    ->required(),
                TextInput::make('reps')
                    ->label('Reps')
                    ->numeric()
                    ->default(10)
                    ->minValue(1)
                    ->maxValue(100)
                    ->step(1)
                    ->required(),
                TextInput::make('weight')
                    ->label('Weight (kg)')
                    ->numeric()
                    ->default(0)
                    ->minValue(0)
                    ->maxValue(500)
                    ->step(0.5)
                    ->required(),
                TextInput::make('rest_seconds')
                    ->label('Rest (seconds)')
                    ->numeric()
                    ->default(60)
                    ->minValue(0)
                    ->maxValue(600)
                    ->step(5)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('exercise.name')
                    ->label('Exercise')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('order')
                    ->label('Order')
                    ->sortable(),
                TextColumn::make('sets')
                    ->label('Sets')
                    ->sortable(),
                TextColumn::make('reps')
                    ->label('Reps')
                    ->sortable(),
                TextColumn::make('weight')
                    ->label('Weight (kg)')
                    ->sortable(),
                TextColumn::make('rest_seconds')
                    ->label('Rest (seconds)')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
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
}
