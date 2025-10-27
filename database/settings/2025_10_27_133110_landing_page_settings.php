<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // Contacto
        $this->migrator->add('landing.contact_email', null);
        $this->migrator->add('landing.contact_phone', null);
        $this->migrator->add('landing.contact_address', null);
        $this->migrator->add('landing.google_maps_embed', null);

        // Redes
        $this->migrator->add('landing.instagram_url', null);
        $this->migrator->add('landing.facebook_url', null);
        $this->migrator->add('landing.whatsapp_url', null);
    }
};
