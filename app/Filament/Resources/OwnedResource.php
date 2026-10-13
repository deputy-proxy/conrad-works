<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;

/**
 * Shared query boundary for resources whose records belong to the signed-in user.
 *
 * Child resources derive ownership through their parent relationship instead of
 * maintaining a second user_id column.
 */
abstract class OwnedResource extends Resource
{
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if (! $user instanceof User) {
            return $query->whereRaw('1 = 0');
        }

        $model = new (static::getModel());

        if (method_exists($model, 'user')) {
            return $query->where($model->qualifyColumn('user_id'), $user->getKey());
        }

        foreach (['habit', 'bookableSlot'] as $relationship) {
            if (method_exists($model, $relationship)) {
                return $query->whereHas(
                    $relationship.'.user',
                    fn (Builder $ownerQuery) => $ownerQuery->whereKey($user->getKey()),
                );
            }
        }

        // Fail closed if a resource model has no recognized ownership path.
        return $query->whereRaw('1 = 0');
    }
}
