<?php

namespace App\Filament\Resources;

use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;

/**
 * Shared base for resources in this single-user application.
 *
 * Records may retain historical user_id values, but the authenticated owner
 * can manage all records through Filament.
 */
abstract class OwnedResource extends Resource
{
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }
}
