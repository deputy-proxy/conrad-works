<?php

namespace App\Filament\Resources\SongResource\Pages;

use Filament\Actions;
use App\Filament\Resources\SongResource;
use Filament\Resources\Pages\ListRecords;

class ListSongs extends ListRecords
{
    protected static string $resource = SongResource::class; 
protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

}
