<?php

namespace App\Filament\Resources\BookableSlotResource\Pages;

use App\Filament\Resources\BookableSlotResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBookableSlot extends CreateRecord
{
    protected static string $resource = BookableSlotResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }

}
