<?php

namespace App\Filament\Resources\DaughterMessageResource\Pages;

use Filament\Actions;
use App\Filament\Resources\DaughterMessageResource;
use Filament\Resources\Pages\ListRecords;

class ListDaughterMessages extends ListRecords
{
    protected static string $resource = DaughterMessageResource::class; 
protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

}
