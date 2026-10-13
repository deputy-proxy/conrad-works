<?php

namespace App\Filament\Resources\BookableSlotResource\Pages;

use Filament\Actions;
use App\Filament\Resources\BookableSlotResource;
use Filament\Resources\Pages\ListRecords;

class ListBookableSlots extends ListRecords
{
    protected static string $resource = BookableSlotResource::class; 
protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

}
