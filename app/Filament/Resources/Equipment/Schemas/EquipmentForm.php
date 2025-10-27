<?php

namespace App\Filament\Resources\Equipment\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class EquipmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('Name'))
                    ->maxLength(255)
                    ->required(),
                Select::make('type')
                    ->label(__('Type'))
                    ->options([
                        'cardio' => 'Cardio',
                        'strength' => 'Strength',
                        'flexibility' => 'Flexibility',
                        'balance' => 'Balance',
                        'mobility' => 'Mobility',
                        'other' => 'Other',
                    ])
                    ->native(false)
                    ->required(),
                Select::make('status')
                    ->label(__('Status'))
                    ->options([
                        'available' => __('Available'),
                        'maintenance' => __('Maintenance'),
                        'out_of_order' => __('Out of order')
                    ])
                    ->default('available')
                    ->native(false)
                    ->required(),
                Textarea::make('description')
                    ->label(__('Description'))
                    ->rows(3)
                    ->maxLength(1000)
                    ->columnSpanFull()
                    ->nullable(),
                TextInput::make('serial_number')
                    ->label(__('Serial number'))
                    ->maxLength(255)
                    ->nullable(),
                TextInput::make('brand')
                    ->label(__('Brand'))
                    ->maxLength(255)
                    ->required(),
                TextInput::make('model')
                    ->label(__('Model'))
                    ->maxLength(255)
                    ->default(null),
                DatePicker::make('purchased_at')
                    ->label(__('Fecha de compra'))
                    ->displayFormat('d/m/Y')
                    ->closeOnDateSelection()
                    ->native(false)
                    ->nullable(),
                TextInput::make('purchase_price')
                    ->label(__('Precio de compra'))
                    ->integer()
                    ->minValue(0)
                    ->maxValue(99999999)
                    ->nullable(),
                TextInput::make('video_url')
                    ->label(__('Video URL'))
                    ->url()
                    ->maxLength(255)
                    ->nullable(),
                FileUpload::make('image_url')
                    ->label(__('Image'))
                    ->image()
                    ->imageEditor()
                    ->disk('public')
                    ->directory('equipments')
                    ->columnSpanFull()
                    ->nullable(),
            ])
            ->columns(3);
    }
}
