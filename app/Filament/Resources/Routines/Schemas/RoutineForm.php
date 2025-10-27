<?php

namespace App\Filament\Resources\Routines\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class RoutineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->required(),
                Textarea::make('description')
                    ->label(__('Description'))
                    ->columnSpanFull()
                    ->rows(3)
                    ->maxLength(1000)
                    ->nullable(),
                Select::make('level')
                    ->label(__('Level'))
                    ->options([
                        'beginner' => __('Beginner'),
                        'intermediate' => __('Intermediate'),
                        'advanced' => __('Advanced'),
                    ])
                    ->default('beginner')
                    ->native(false)
                    ->required(),
                TextInput::make('duration_minutes')
                    ->label(__('Duration (Minutes)'))
                    ->integer()
                    ->minValue(1)
                    ->maxValue(300)
                    ->step(1)
                    ->nullable(),
                Select::make('type')
                    ->label(__('Type'))
                    ->options([
                        'strength' => __('Strength'),
                        'cardio' => __('Cardio'),
                        'flexibility' => __('Flexibility'),
                        'balance' => __('Balance'),
                    ])
                    ->default('strength')
                    ->native(false)
                    ->required(),
                Select::make('muscle_group')
                    ->label(__('Muscle Group'))
                    ->options([
                        'full_body' => __('Full Body'),
                        'upper_body' => __('Upper Body'),
                        'lower_body' => __('Lower Body'),
                        'core' => __('Core'),
                    ])
                    ->native(false)
                    ->nullable(),
            ]);
    }
}
