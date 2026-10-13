<?php

namespace App\Filament\Resources\VentureResource\Pages;

use Filament\Actions;
use App\Filament\Resources\VentureResource;
use Filament\Resources\Pages\ListRecords;

class ListVentures extends ListRecords
{
    protected static string $resource = VentureResource::class; 
protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

}
