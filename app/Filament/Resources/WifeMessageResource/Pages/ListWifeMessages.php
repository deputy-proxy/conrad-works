<?php

namespace App\Filament\Resources\WifeMessageResource\Pages;

use Filament\Actions;
use App\Filament\Resources\WifeMessageResource;
use Filament\Resources\Pages\ListRecords;

class ListWifeMessages extends ListRecords
{
    protected static string $resource = WifeMessageResource::class; 
protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

}
