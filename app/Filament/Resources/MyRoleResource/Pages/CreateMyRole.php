<?php

namespace App\Filament\Resources\MyRoleResource\Pages;

use App\Filament\Resources\MyRoleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMyRole extends CreateRecord
{
    protected static string $resource = MyRoleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
