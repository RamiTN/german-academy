<?php

namespace App\Policies;

use App\Models\Meeting;
use App\Models\User;

class MeetingPolicy
{
    /**
     * Determine whether the user can view any meetings.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin() || $user->isTeacher() || $user->isStudent();
    }

    /**
     * Determine whether the user can view a specific meeting.
     */
    public function view(User $user, Meeting $meeting): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isTeacher() && $user->teacher) {
            return $meeting->teacher_id === $user->teacher->id || $meeting->classGroup?->teacher_id === $user->teacher->id;
        }

        if ($user->isStudent() && $user->student) {
            return $meeting->class_group_id === $user->student->class_group_id;
        }

        return false;
    }

    /**
     * Determine whether the user can create meetings.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isTeacher();
    }

    /**
     * Determine whether the user can update the meeting (e.g., set meet_link, status).
     */
    public function update(User $user, Meeting $meeting): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isTeacher() && $user->teacher) {
            return $meeting->teacher_id === $user->teacher->id || $meeting->classGroup?->teacher_id === $user->teacher->id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the meeting.
     */
    public function delete(User $user, Meeting $meeting): bool
    {
        return $this->update($user, $meeting);
    }

    /**
     * Determine whether the user can join the meeting.
     */
    public function join(User $user, Meeting $meeting): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isTeacher() && $user->teacher) {
            return $meeting->teacher_id === $user->teacher->id || $meeting->classGroup?->teacher_id === $user->teacher->id;
        }

        if ($user->isStudent() && $user->student) {
            return $user->student->class_group_id === $meeting->class_group_id;
        }

        return false;
    }
}
