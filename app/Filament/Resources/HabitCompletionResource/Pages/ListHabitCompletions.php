<?php

namespace App\Filament\Resources\HabitCompletionResource\Pages;

use Filament\Actions;
use App\Filament\Resources\HabitCompletionResource;
use Filament\Resources\Pages\ListRecords;

class ListHabitCompletions extends ListRecords
{
    protected static string $resource = HabitCompletionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

}
