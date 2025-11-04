<?php

namespace App\Filament\Resources\UserMemberships;

use App\Filament\Resources\UserMemberships\Pages\CreateUserMembership;
use App\Filament\Resources\UserMemberships\Pages\EditUserMembership;
use App\Filament\Resources\UserMemberships\Pages\ListUserMemberships;
use App\Filament\Resources\UserMemberships\Schemas\UserMembershipForm;
use App\Filament\Resources\UserMemberships\Tables\UserMembershipsTable;
use App\Models\UserMembership;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class UserMembershipResource extends Resource
{
    protected static ?string $model = UserMembership::class;
    protected static ?string $navigationLabel = 'Membresías';
    protected static ?string $pluralModelLabel = 'membresías';
    protected static ?string $modelLabel = 'membresía';
    protected static ?string $slug = 'memberships';
    protected static string | UnitEnum | null $navigationGroup = 'Membresías';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedIdentification;

    public static function form(Schema $schema): Schema
    {
        return UserMembershipForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UserMembershipsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUserMemberships::route('/'),
            'create' => CreateUserMembership::route('/create'),
            'edit' => EditUserMembership::route('/{record}/edit'),
        ];
    }
}
