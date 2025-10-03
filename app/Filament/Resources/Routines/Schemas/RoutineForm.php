<?php

namespace App\Filament\Resources\Routines\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class RoutineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Routine Name')
                    ->columnSpanFull()
                    ->required(),
                Textarea::make('description')
                    ->label('Description')
                    ->columnSpanFull()
                    ->rows(3)
                    ->maxLength(1000)
                    ->nullable(),
                Select::make('level')
                    ->label('Level')
                    ->options([
                        'beginner' => 'Beginner',
                        'intermediate' => 'Intermediate',
                        'advanced' => 'Advanced'
                    ])
                    ->default('beginner')
                    ->native(false)
                    ->required(),
                TextInput::make('duration_minutes')
                    ->label('Duration (minutes)')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(300)
                    ->step(1)
                    ->nullable(),
                Toggle::make('is_active')
                    ->label('Is Active')
                    ->inline(false)
                    ->default(true)
                    ->hiddenOn('create')
                    ->required(),
            ]);
    }
}
