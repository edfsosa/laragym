<?php
namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class LandingPageSettings extends Settings
{
    // Contacto
    public ?string $contact_email;
    public ?string $contact_phone;
    public ?string $contact_address;
    public ?string $google_maps_embed;

    // Redes
    public ?string $instagram_url;
    public ?string $facebook_url;
    public ?string $whatsapp_url;

    // Información del negocio
    public ?string $business_name;
    public ?string $business_slogan;
    public ?string $business_hours;

    // Redes adicionales
    public ?string $tiktok_url;
    public ?string $youtube_url;

    // Sección Hero
    public ?string $hero_title;
    public ?string $hero_subtitle;
    public ?string $hero_cta_text;
    public ?string $hero_cta_link;

    // Sección Acerca de
    public ?string $about_title;
    public ?string $about_description;

    // Estadísticas
    public ?int $stats_members;
    public ?int $stats_trainers;
    public ?int $stats_classes;

    public static function group(): string
    {
        return 'landing';
    }
}
