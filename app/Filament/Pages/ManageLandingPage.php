<?php

namespace App\Filament\Pages;

use App\Settings\LandingPageSettings as SettingsLandingPageSettings;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ManageLandingPage extends SettingsPage
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;
    protected static string $settings = SettingsLandingPageSettings::class;
    protected static ?string $navigationLabel = 'Landing Page';
    protected static ?string $title = 'Ajustes de la Landing Page';
    protected static ?string $slug = 'landing-page-settings';
    protected ?string $subheading = 'Configura los detalles de contacto y enlaces sociales para la landing page.';
    protected static ?int $navigationSort = 10;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Contact details'))
                    ->schema([
                        TextInput::make('contact_email')
                            ->label(__('Contact email'))
                            ->email()
                            ->required(),
                        TextInput::make('contact_phone')
                            ->label(__('Contact phone'))
                            ->required(),
                        TextInput::make('contact_address')
                            ->label(__('Contact address'))
                            ->required(),
                        TextInput::make('google_maps_embed')
                            ->label('Embed de Google Maps')
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
                Section::make(__('Social media links'))
                    ->schema([
                        TextInput::make('instagram_url')
                            ->label(__('Instagram URL'))
                            ->url()
                            ->required(),
                        TextInput::make('facebook_url')
                            ->label(__('Facebook URL'))
                            ->url()
                            ->required(),
                        TextInput::make('whatsapp_url')
                            ->label(__('WhatsApp URL'))
                            ->url()
                            ->required(),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }
}
