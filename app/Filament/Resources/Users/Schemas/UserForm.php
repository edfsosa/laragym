<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Full name')
                    ->maxLength(255)
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->required(),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->dehydrateStateUsing(fn($state) => $state ? bcrypt($state) : null)
                    ->required(fn(string $context): bool => $context === 'create')
                    ->maxLength(255),
                Select::make('gender')
                    ->label('Gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female'
                    ])
                    ->nullable(),
                TextInput::make('document_number')
                    ->label('Document number')
                    ->maxLength(20)
                    ->nullable(),
                DatePicker::make('birth_date')
                    ->label('Birth date')
                    ->displayFormat('d/m/Y')
                    ->native(false)
                    ->closeOnDateSelection()
                    ->minDate(now()->subYears(100))
                    ->maxDate(now()->subYears(18))
                    ->nullable(),
                TextInput::make('phone')
                    ->label('Phone number')
                    ->tel()
                    ->maxLength(20)
                    ->nullable(),
                TextInput::make('address')
                    ->label('Address')
                    ->maxLength(255)
                    ->nullable(),
                Select::make('city')
                    ->label('City')
                    ->options([
                        'Asunción' => 'Asunción',
                        'Areguá' => 'Areguá',
                        'Capiatá' => 'Capiatá',
                        'Fernando de la Mora' => 'Fernando de la Mora',
                        'Guarambaré' => 'Guarambaré',
                        'Itá' => 'Itá',
                        'Itauguá' => 'Itauguá',
                        'Julián Augusto Saldívar' => 'Julián Augusto Saldívar',
                        'Lambaré' => 'Lambaré',
                        'Limpio' => 'Limpio',
                        'Luque' => 'Luque',
                        'Mariano Roque Alonso' => 'Mariano Roque Alonso',
                        'Nueva Italia' => 'Nueva Italia',
                        'Ñemby' => 'Ñemby',
                        'San Antonio' => 'San Antonio',
                        'San Lorenzo' => 'San Lorenzo',
                        'Villa Elisa' => 'Villa Elisa',
                        'Villeta' => 'Villeta',
                        'Ypacaraí' => 'Ypacaraí',
                        'Ypané' => 'Ypané',
                        'Other' => 'Other',
                    ])
                    ->searchable()
                    ->native(false)
                    ->nullable(),
                FileUpload::make('avatar')
                    ->label('Avatar')
                    ->image()
                    ->imageEditor()
                    ->circleCropper()
                    ->directory('avatars')
                    ->avatar()
                    ->maxSize(2048)
                    ->nullable(),
                Select::make('roles')
                    ->label('Roles')
                    ->relationship('roles', 'name')
                    ->preload()
                    ->native(false)
                    ->required(),
            ]);
    }
}
