<?php

namespace App\Filament\Resources\WifeMessageResource\Pages;

use App\Filament\Resources\WifeMessageResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWifeMessage extends CreateRecord
{
    protected static string $resource = WifeMessageResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }

}
