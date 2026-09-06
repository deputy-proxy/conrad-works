<?php

namespace App\Filament\Resources\MyRoleResource\Pages;

use App\Filament\Resources\MyRoleResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListMyRoles extends ListRecords
{
    protected static string $resource = MyRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
