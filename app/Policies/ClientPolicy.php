<?php

namespace App\Policies;

use App\Models\Client;
use App\Models\User;

class ClientPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [User::ROLE_ADMIN, User::ROLE_COMMERCIAL]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Client $client): bool
    {
        return in_array($user->role, [User::ROLE_ADMIN, User::ROLE_COMMERCIAL]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, [User::ROLE_ADMIN, User::ROLE_COMMERCIAL]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Client $client): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Client $client): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can perform payment actions.
     */
    public function managePayment(User $user, Client $client): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can suspend/activate clients.
     */
    public function manageStatus(User $user, Client $client): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can export client data.
     */
    public function export(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can send notifications.
     */
    public function sendNotification(User $user, Client $client): bool
    {
        return $user->isAdmin();
    }
}
