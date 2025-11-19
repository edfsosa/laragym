<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        // Información del negocio
        $this->migrator->add('landing.business_name', 'Smart Gym');
        $this->migrator->add('landing.business_slogan', 'Entrená, superate y alcanzá tus metas');
        $this->migrator->add('landing.business_hours', 'Lun–Vie 06:00–22:00 / Sáb 07:00–18:00');

        // Redes adicionales
        $this->migrator->add('landing.tiktok_url', null);
        $this->migrator->add('landing.youtube_url', null);

        // Sección Hero
        $this->migrator->add('landing.hero_title', 'Transformá tu cuerpo y tu mente');
        $this->migrator->add('landing.hero_subtitle', 'Tu bienestar empieza hoy');
        $this->migrator->add('landing.hero_cta_text', 'Unite ahora');
        $this->migrator->add('landing.hero_cta_link', '/login');
        $this->migrator->add('landing.about_title', 'Sobre Nosotros');
        $this->migrator->add('landing.about_description', 'En Smart Gym, nos dedicamos a ayudarte a alcanzar tus objetivos de fitness con instalaciones de primera clase y entrenadores expertos.');
        $this->migrator->add('landing.stats_members', 150);
        $this->migrator->add('landing.stats_trainers', 20);
        $this->migrator->add('landing.stats_classes', 35);
    }
};
