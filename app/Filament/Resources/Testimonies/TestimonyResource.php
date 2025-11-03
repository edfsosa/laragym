<?php

namespace App\Filament\Resources\Testimonies;

use App\Filament\Resources\Testimonies\Pages\ManageTestimonies;
use App\Models\Testimony;
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

class TestimonyResource extends Resource
{
    protected static ?string $model = Testimony::class;
    protected static ?string $navigationLabel = 'Testimonios';
    protected static ?string $pluralModelLabel = 'testimonios';
    protected static ?string $modelLabel = 'testimonio';
    protected static string | UnitEnum | null $navigationGroup = 'Usuarios';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('author_name')
                    ->label(__('Author Name'))
                    ->maxLength(255)
                    ->required(),
                Textarea::make('content')
                    ->label(__('Content'))
                    ->rows(5)
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('author_name')
                    ->label(__('Author Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('content')
                    ->label(__('Content'))
                    ->limit(80),
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
            'index' => ManageTestimonies::route('/'),
        ];
    }
}
