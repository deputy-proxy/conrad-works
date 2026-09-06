<?php

namespace App\Filament\Resources\WifeMessageResource\Pages;

use Filament\Actions;
use App\Filament\Resources\WifeMessageResource;
use Filament\Resources\Pages\ListRecords;

class ListWifeMessages extends ListRecords
{
    protected static string $resource = WifeMessageResource::class;
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
