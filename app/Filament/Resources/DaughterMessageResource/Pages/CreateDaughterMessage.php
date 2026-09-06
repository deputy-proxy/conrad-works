<?php

namespace App\Filament\Resources\DaughterMessageResource\Pages;

use App\Filament\Resources\DaughterMessageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDaughterMessage extends CreateRecord
{
    protected static string $resource = DaughterMessageResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }

}
