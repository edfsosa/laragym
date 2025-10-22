<?php

namespace App\Filament\Resources\Memberships\Pages;

use App\Filament\Resources\Memberships\MembershipResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageMemberships extends ManageRecords
{
    protected static string $resource = MembershipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
