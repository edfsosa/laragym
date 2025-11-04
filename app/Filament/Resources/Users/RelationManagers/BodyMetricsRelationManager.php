<?php

namespace App\Filament\Resources\Users\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BodyMetricsRelationManager extends RelationManager
{
    protected static string $relationship = 'bodyMetrics';
    protected static ?string $modelLabel = 'metría corporal';
    protected static ?string $pluralModelLabel = 'metrías corporales';


    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('measurement_date')
                    ->label(__('Measurement date'))
                    ->displayFormat('d/m/Y')
                    ->closeOnDateSelection()
                    ->native(false)
                    ->default(now())
                    ->required(),
                TextInput::make('weight')
                    ->label(__('Weight'))
                    ->suffix('kg')
                    ->placeholder('e.g., 70.5')
                    ->numeric()
                    ->minValue(10)
                    ->maxValue(500)
                    ->step(0.1)
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $weight = floatval($state);
                        $height = floatval($get('height'));

                        if ($weight > 0 && $height > 0) {
                            $bmi = $weight / ($height * $height);
                            $set('bmi', round($bmi, 2));
                        }
                    }),
                TextInput::make('height')
                    ->label(__('Height'))
                    ->suffix('m')
                    ->placeholder('e.g., 1.75')
                    ->numeric()
                    ->minValue(0.5)
                    ->maxValue(3)
                    ->step(0.01)
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $height = floatval($state);
                        $weight = floatval($get('weight'));

                        if ($weight > 0 && $height > 0) {
                            $bmi = $weight / ($height * $height);
                            $set('bmi', round($bmi, 2));
                        }
                    }),
                TextInput::make('bmi')
                    ->label(__('BMI'))
                    ->numeric()
                    ->disabled()
                    ->dehydrated(),
                Textarea::make('notes')
                    ->label(__('Notes'))
                    ->rows(3)
                    ->maxLength(65535)
                    ->columnSpanFull()
                    ->nullable(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('measurement_date')
                    ->label(__('Measurement date'))
                    ->date('d/m/Y')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('weight')
                    ->label(__('Weight'))
                    ->suffix(' kg')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('height')
                    ->label(__('Height'))
                    ->suffix(' m')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('bmi')
                    ->label(__('BMI'))
                    ->sortable()
                    ->searchable(),
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
            ->defaultSort('measurement_date', 'desc')
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
        return __('Body Metrics');
    }
}
