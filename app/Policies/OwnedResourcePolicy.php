<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Authorization rules for the single-user application's records.
 *
 * Ownership columns are retained for data integrity and create-time defaults,
 * but historical owner IDs do not restrict the sole authenticated user.
 */
class OwnedResourcePolicy
{
    public function viewAny(User $user): bool { return true; }

    public function view(User $user, Model $record): bool { return true; }

    public function create(User $user): bool { return true; }

    public function update(User $user, Model $record): bool { return true; }

    public function delete(User $user, Model $record): bool { return true; }

    public function deleteAny(User $user): bool { return true; }
}
