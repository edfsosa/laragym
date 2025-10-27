<?php

namespace App\Filament\Resources\Testimonies\Pages;

use App\Filament\Resources\Testimonies\TestimonyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTestimonies extends ManageRecords
{
    protected static string $resource = TestimonyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
