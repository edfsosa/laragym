<?php

namespace App\Filament\Resources\Routines\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
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

                Repeater::make('routineExercises')
                    ->relationship()
                    ->columnSpanFull()
                    ->addActionLabel(__('Add Exercise'))
                    ->collapsible()
                    ->cloneable()
                    ->reorderableWithButtons()
                    ->orderColumn('order')
                    ->schema([
                        Grid::make(4)
                            ->schema([
                                TextInput::make('order')
                                    ->label(__('Order'))
                                    ->integer()
                                    ->minValue(1)
                                    ->required(),
                                Select::make('exercise_id')
                                    ->label(__('Exercise'))
                                    ->relationship('exercise', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->native(false)
                                    ->placeholder(__('Select an exercise'))
                                    ->required(),
                                TextInput::make('sets')
                                    ->label(__('Sets'))
                                    ->integer()
                                    ->minValue(1)
                                    ->nullable(),
                                TextInput::make('reps')
                                    ->label(__('Reps'))
                                    ->integer()
                                    ->minValue(1)
                                    ->nullable(),
                            ]),
                        Grid::make(3)
                            ->schema([
                                TextInput::make('duration_seconds')
                                    ->label(__('Duration (Seconds)'))
                                    ->integer()
                                    ->minValue(1)
                                    ->nullable(),
                                TextInput::make('rest_seconds')
                                    ->label(__('Rest (Seconds)'))
                                    ->integer()
                                    ->minValue(0)
                                    ->nullable(),
                                TextInput::make('weight_kg')
                                    ->label(__('Weight (kg)'))
                                    ->numeric()
                                    ->minValue(0)
                                    ->nullable(),
                            ]),
                    ])
            ]);
    }
}
