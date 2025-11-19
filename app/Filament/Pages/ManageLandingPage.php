<?php

namespace App\Filament\Pages;

use App\Settings\LandingPageSettings as SettingsLandingPageSettings;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageLandingPage extends SettingsPage
{
    protected static string | UnitEnum | null $navigationGroup = 'Gimnasio';
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
                Section::make(__('Business details'))
                    ->schema([
                        TextInput::make('business_name')
                            ->label(__('Business name'))
                            ->maxLength(50)
                            ->required(),
                        TextInput::make('business_slogan')
                            ->label(__('Business slogan'))
                            ->maxLength(100)
                            ->required(),
                        TextInput::make('business_hours')
                            ->label(__('Business hours'))
                            ->maxLength(100)
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make(__('Hero Section'))
                    ->schema([
                        TextInput::make('hero_title')
                            ->label(__('Hero title'))
                            ->maxLength(100)
                            ->required(),
                        TextInput::make('hero_subtitle')
                            ->label(__('Hero subtitle'))
                            ->maxLength(150)
                            ->required(),
                        TextInput::make('hero_cta_text')
                            ->label(__('Hero CTA text'))
                            ->maxLength(50)
                            ->required(),
                        TextInput::make('hero_cta_link')
                            ->label(__('Hero CTA link'))
                            ->required(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

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
                            ->maxLength(500)
                            ->nullable(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),

                Section::make(__('Social media links'))
                    ->schema([
                        TextInput::make('instagram_url')
                            ->label(__('Instagram URL'))
                            ->url(),
                        TextInput::make('facebook_url')
                            ->label(__('Facebook URL'))
                            ->url(),
                        TextInput::make('whatsapp_url')
                            ->label(__('WhatsApp URL'))
                            ->url(),
                        TextInput::make('tiktok_url')
                            ->label(__('TikTok URL'))
                            ->url(),
                        TextInput::make('youtube_url')
                            ->label(__('YouTube URL'))
                            ->url(),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
            ]);
    }
}
