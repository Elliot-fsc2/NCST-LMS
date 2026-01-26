<?php

namespace App\Policies;

use App\Models\Section;
use App\Models\User;

class SectionPolicy
{
    public function before(User $user, $ability): ?bool
    {
        if ($user->profile?->is_department_head) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'teacher' || $user->role === 'student';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Section $section): bool
    {
        if ($user->role === 'teacher') {
            return $section->teacher_id === $user->profile->id;
        }

        if ($user->role === 'student') {
            return $section->students()->where('student_id', $user->profile->id)->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'teacher';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Section $section): bool
    {
        if ($user->role === 'teacher') {
            return $section->teacher_id === $user->profile->id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Section $section): bool
    {
        if ($user->role === 'teacher') {
            return $section->teacher_id === $user->profile->id;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Section $section): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Section $section): bool
    {
        return false;
    }
}
