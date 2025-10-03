<?php

namespace App\Filament\Resources\Exercises;

use App\Filament\Resources\Exercises\Pages\ManageExercises;
use App\Models\Exercise;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ExerciseResource extends Resource
{
    protected static ?string $model = Exercise::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('equipment_id')
                    ->label('Equipment')
                    ->relationship('equipment', 'name')
                    ->preload()
                    ->searchable()
                    ->native(false)
                    ->nullable(),
                TextInput::make('name')
                    ->label('Exercise Name')
                    ->required(),
                Textarea::make('description')
                    ->label('Description')
                    ->columnSpanFull()
                    ->rows(3)
                    ->maxLength(1000)
                    ->nullable(),
                Select::make('muscle_group')
                    ->label('Muscle Group')
                    ->options([
                        'chest' => 'Chest',
                        'back' => 'Back',
                        'legs' => 'Legs',
                        'arms' => 'Arms',
                        'shoulders' => 'Shoulders',
                        'core' => 'Core',
                    ])
                    ->native(false)
                    ->nullable(),
                TextInput::make('video_url')
                    ->label('Video URL')
                    ->url()
                    ->nullable(),
                FileUpload::make('image_url')
                    ->label('Image')
                    ->disk('public')
                    ->directory('exercises/images')
                    ->columnSpanFull()
                    ->image()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                ImageColumn::make('image_url')
                    ->label('Image')
                    ->circular()
                    ->disk('public'),
                TextColumn::make('name')
                    ->label('Exercise Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('muscle_group')
                    ->label('Muscle Group')
                    ->sortable(),
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
            'index' => ManageExercises::route('/'),
        ];
    }
}
