<?php

namespace App\Filament\Resources\DaughterMessageResource\Pages;

use Filament\Actions;
use App\Filament\Resources\DaughterMessageResource;
use Filament\Resources\Pages\ListRecords;

class ListDaughterMessages extends ListRecords
{
    protected static string $resource = DaughterMessageResource::class;
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
