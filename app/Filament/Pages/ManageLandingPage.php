<?php

namespace App\Filament\Pages;

use App\Settings\LandingPageSettings as SettingsLandingPageSettings;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageLandingPage extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;
    protected static string | UnitEnum | null $navigationGroup = 'Settings';
    protected static string $settings = SettingsLandingPageSettings::class;
    protected static ?string $navigationLabel = 'Landing Page';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('contact_email')
                    ->label('Correo Electrónico de Contacto')
                    ->email()
                    ->required(),
                TextInput::make('contact_phone')
                    ->label('Teléfono de Contacto')
                    ->required(),
                TextInput::make('contact_address')
                    ->label('Dirección de Contacto')
                    ->required(),
                TextInput::make('google_maps_embed')
                    ->label('Embed de Google Maps')
                    ->required(),
                TextInput::make('instagram_url')
                    ->label('URL de Instagram')
                    ->url()
                    ->required(),
                TextInput::make('facebook_url')
                    ->label('URL de Facebook')
                    ->url()
                    ->required(),
                TextInput::make('whatsapp_url')
                    ->label('URL de WhatsApp')
                    ->url()
                    ->required(),
            ]);
    }
}
