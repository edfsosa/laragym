<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('User Information')
                    ->description('Enter the user details below.')
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required(),
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->visibleOn('create')
                            ->required(fn(string $context) => $context === 'create')
                            ->maxLength(255),
                        Select::make('roles')
                            ->label('Roles')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->native(false)
                            ->required(),
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'suspended' => 'Suspended',
                            ])
                            ->native(false)
                            ->default('active')
                            ->hiddenOn('create'),
                    ])
                    ->columnSpanFull()
                    ->columns(4),

                Section::make('Personal Data')
                    ->description('Optional personal data.')
                    ->relationship('personalData')
                    ->schema([
                        FileUpload::make('avatar')
                            ->label('Avatar')
                            ->image()
                            ->imageEditor()
                            ->avatar()
                            ->circleCropper()
                            ->disk('public')
                            ->directory('avatars')
                            ->maxSize(2048),
                        DatePicker::make('birth_date')
                            ->label('Birth Date')
                            ->displayFormat('d/m/Y')
                            ->closeOnDateSelection()
                            ->native(false)
                            ->minDate(now()->subYears(100))
                            ->maxDate(now()->subYears(15)),
                        Radio::make('gender')
                            ->label('Gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female'
                            ])
                            ->inline(),
                        TextInput::make('document_number')
                            ->label('Document Number')
                            ->maxLength(30),
                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->tel()
                            ->maxLength(20),
                    ])
                    ->columnSpanFull()
                    ->columns(3)
                    ->visibleOn('edit'),

                Section::make('Address Information')
                    ->description('Optional address data.')
                    ->relationship('address')
                    ->schema([
                        Select::make('city_id')
                            ->label('City')
                            ->relationship('city', 'name')
                            ->searchable()
                            ->native(false),
                        TextInput::make('street')
                            ->label('Street')
                            ->maxLength(100),
                        TextInput::make('number')
                            ->label('Number')
                            ->maxLength(5),
                        TextInput::make('reference')
                            ->label('Reference')
                            ->maxLength(150)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->columns(3)
                    ->visibleOn('edit'),

                Section::make('Membership Information')
                    ->description('Optional membership data.')
                    ->schema([
                        Repeater::make('memberships')
                            ->relationship()
                            ->schema([
                                Select::make('membership_id')
                                    ->label('Membership')
                                    ->relationship('membership', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->native(false)
                                    ->required(),
                                DatePicker::make('start_at')
                                    ->label('Start At')
                                    ->displayFormat('d/m/Y')
                                    ->native(false)
                                    ->closeOnDateSelection()
                                    ->default(now())
                                    ->required(),
                                Select::make('status')
                                    ->label('Status')
                                    ->options([
                                        'active' => 'Active',
                                        'expired' => 'Expired',
                                        'canceled' => 'Canceled',
                                    ])
                                    ->native(false)
                                    ->visibleOn('edit')
                                    ->required(),
                            ])
                            ->collapsible()
                            ->itemNumbers()
                            ->columns(3)
                    ])
                    ->columnSpanFull()
                    ->visibleOn('edit')
                    ->visible(fn(?User $record) => $record?->hasRole('Member')),
            ]);
    }
}
