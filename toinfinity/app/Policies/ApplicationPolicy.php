<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;

class ApplicationPolicy
{
    /**
     * Determine whether the user can view any applications.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isTeacher();
    }

    /**
     * Determine whether the user can view the application.
     */
    public function view(User $user, Application $application): bool
    {
        return $user->isAdmin() || $user->isTeacher();
    }

    /**
     * Determine whether the user can update the application status / details.
     */
    public function update(User $user, Application $application): bool
    {
        return $user->isAdmin() || $user->isTeacher();
    }
}
