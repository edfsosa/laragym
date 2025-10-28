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

                Section::make(__('User Details'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('Name'))
                            ->maxLength(255)
                            ->required(),
                        TextInput::make('email')
                            ->label(__('Email'))
                            ->email()
                            ->maxLength(255)
                            ->required(),
                        TextInput::make('password')
                            ->label(__('Password'))
                            ->password()
                            ->visibleOn('create')
                            ->required(fn(string $context) => $context === 'create')
                            ->maxLength(255),
                        Select::make('roles')
                            ->label(__('Roles'))
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->native(false)
                            ->required(),
                        Select::make('status')
                            ->label(__('Status'))
                            ->options([
                                'active' => __('Active'),
                                'inactive' => __('Inactive'),
                                'suspended' => __('Suspended'),
                            ])
                            ->native(false)
                            ->default('active')
                            ->hiddenOn('create'),
                    ])
                    ->columnSpanFull()
                    ->columns(4),

                Section::make(__('Personal Information'))
                    ->relationship('personalData')
                    ->schema([
                        FileUpload::make('avatar')
                            ->label(__('Avatar'))
                            ->image()
                            ->imageEditor()
                            ->avatar()
                            ->circleCropper()
                            ->disk('public')
                            ->directory('avatars')
                            ->maxSize(2048),
                        DatePicker::make('birth_date')
                            ->label(__('Birth Date'))
                            ->displayFormat('d/m/Y')
                            ->closeOnDateSelection()
                            ->native(false)
                            ->minDate(now()->subYears(100))
                            ->maxDate(now()->subYears(15)),
                        Radio::make('gender')
                            ->label(__('Gender'))
                            ->options([
                                'male' => __('Male'),
                                'female' => __('Female')
                            ])
                            ->inline(),
                        TextInput::make('document_number')
                            ->label(__('Document Number'))
                            ->integer()
                            ->minValue(1)
                            ->maxLength(30)
                            ->step(1),
                        TextInput::make('phone')
                            ->label(__('Phone'))
                            ->tel()
                            ->maxLength(20),
                    ])
                    ->columnSpanFull()
                    ->columns(3)
                    ->visibleOn('edit'),

                Section::make(__('Address Information'))
                    ->relationship('address')
                    ->schema([
                        Select::make('city_id')
                            ->label(__('City'))
                            ->relationship('city', 'name')
                            ->searchable()
                            ->native(false),
                        TextInput::make('street')
                            ->label(__('Street'))
                            ->maxLength(100),
                        TextInput::make('number')
                            ->label(__('Number'))
                            ->maxLength(5),
                        TextInput::make('reference')
                            ->label(__('Reference'))
                            ->maxLength(150)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->columns(3)
                    ->visibleOn('edit'),

                /* Section::make(__('Memberships Information'))
                    ->schema([
                        Repeater::make('memberships')
                            ->relationship()
                            ->schema([
                                Select::make('membership_id')
                                    ->label(__('Membership'))
                                    ->relationship('membership', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->native(false)
                                    ->required(),
                                DatePicker::make('start_at')
                                    ->label(__('Start Date'))
                                    ->displayFormat('d/m/Y')
                                    ->native(false)
                                    ->closeOnDateSelection()
                                    ->default(now())
                                    ->required(),
                                Select::make('status')
                                    ->label(__('Status'))
                                    ->options([
                                        'active' => __('Active'),
                                        'expired' => __('Expired'),
                                        'canceled' => __('Canceled'),
                                    ])
                                    ->native(false)
                                    ->visibleOn('edit')
                                    ->required(),
                            ])
                            ->addActionLabel(__('Add Membership'))
                            ->collapsible()
                            ->columns(3)
                    ])
                    ->columnSpanFull()
                    ->visibleOn('edit')
                    ->visible(fn(?User $record) => $record?->hasRole('Member')), */
            ]);
    }
}
