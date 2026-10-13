<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Shared authorization boundary for user-owned resources and their child records.
 */
class OwnedResourcePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Model $record): bool
    {
        return $this->isOwnedBy($user, $record);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Model $record): bool
    {
        return $this->isOwnedBy($user, $record);
    }

    public function delete(User $user, Model $record): bool
    {
        return $this->isOwnedBy($user, $record);
    }

    /**
     * Bulk actions are safe because the resource query is owner-scoped as well.
     */
    public function deleteAny(User $user): bool
    {
        return true;
    }

    protected function isOwnedBy(User $user, Model $record): bool
    {
        if (method_exists($record, 'user')) {
            return (string) $record->getAttribute('user_id') === (string) $user->getKey();
        }

        foreach (['habit', 'bookableSlot'] as $relationship) {
            if (method_exists($record, $relationship)) {
                return $record->{$relationship}()
                    ->whereHas('user', fn ($query) => $query->whereKey($user->getKey()))
                    ->exists();
            }
        }

        return false;
    }
}
