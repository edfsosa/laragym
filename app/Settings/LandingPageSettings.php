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

    public static function group(): string
    {
        return 'landing';
    }
}
