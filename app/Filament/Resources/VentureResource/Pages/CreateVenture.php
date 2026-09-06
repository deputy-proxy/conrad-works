<?php

namespace App\Filament\Resources\VentureResource\Pages;

use App\Filament\Resources\VentureResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVenture extends CreateRecord
{
    protected static string $resource = VentureResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }

}
