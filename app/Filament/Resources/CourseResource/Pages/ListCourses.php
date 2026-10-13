<?php

namespace App\Filament\Resources\CourseResource\Pages;

use Filament\Actions;
use App\Filament\Resources\CourseResource;
use Filament\Resources\Pages\ListRecords;

class ListCourses extends ListRecords
{
    protected static string $resource = CourseResource::class; 
protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

}
