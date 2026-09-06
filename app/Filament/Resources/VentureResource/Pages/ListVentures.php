<?php

namespace App\Filament\Resources\VentureResource\Pages;

use Filament\Actions;
use App\Filament\Resources\VentureResource;
use Filament\Resources\Pages\ListRecords;

class ListVentures extends ListRecords
{
    protected static string $resource = VentureResource::class;
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

}
