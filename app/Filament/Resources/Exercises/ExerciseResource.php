<?php

namespace App\Filament\Resources\Exercises;

use App\Filament\Resources\Exercises\Pages\ManageExercises;
use App\Models\Exercise;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ExerciseResource extends Resource
{
    protected static ?string $model = Exercise::class;
    protected static ?string $navigationLabel = 'Ejercicios';
    protected static ?string $pluralModelLabel = 'ejercicios';
    protected static ?string $modelLabel = 'ejercicio';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPlayCircle;
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('equipment_id')
                    ->label(__('Equipment'))
                    ->relationship('equipment', 'name')
                    ->preload()
                    ->searchable()
                    ->native(false)
                    ->nullable(),
                TextInput::make('name')
                    ->label(__('Name'))
                    ->required(),
                Textarea::make('description')
                    ->label(__('Description'))
                    ->columnSpanFull()
                    ->rows(3)
                    ->maxLength(1000)
                    ->nullable(),
                Select::make('muscle_group')
                    ->label(__('Muscle group'))
                    ->options([
                        'Chest' => 'Chest',
                        'Back' => 'Back',
                        'Legs' => 'Legs',
                        'Arms' => 'Arms',
                        'Shoulders' => 'Shoulders',
                        'Core' => 'Core',
                        'Full Body' => 'Full body',
                    ])
                    ->native(false)
                    ->nullable(),
                TextInput::make('video_url')
                    ->label(__('Video URL'))
                    ->url()
                    ->nullable(),
                TextInput::make('image_url')
                    ->label(__('Image URL'))
                    ->url()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('muscle_group')
                    ->label(__('Muscle group'))
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'Chest' => __('Chest'),
                        'Back' => __('Back'),
                        'Legs' => __('Legs'),
                        'Arms' => __('Arms'),
                        'Shoulders' => __('Shoulders'),
                        'Core' => __('Core'),
                        'Full Body' => __('Full body'),
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('Created'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('Updated'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('muscle_group')
                    ->label(__('Muscle group'))
                    ->options([
                        'Chest' => __('Chest'),
                        'Back' => __('Back'),
                        'Legs' => __('Legs'),
                        'Arms' => __('Arms'),
                        'Shoulders' => __('Shoulders'),
                        'Core' => __('Core'),
                        'Full Body' => __('Full body'),
                    ])
                    ->multiple()
                    ->native(false),
            ])
            ->recordActions([
                Action::make('view_video')
                    ->label(__('View Video'))
                    ->icon(Heroicon::Eye)
                    ->color('secondary')
                    ->url(fn(Exercise $record): ?string => $record->video_url)
                    ->openUrlInNewTab()
                    ->visible(fn(Exercise $record): bool => !empty($record->video_url)),
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
