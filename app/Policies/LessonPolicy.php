<?php

namespace App\Policies;

use App\Models\Lesson;
use App\Models\User;

class LessonPolicy
{
    /**
     * Determine whether the user can view any lessons.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'teacher' || $user->role === 'student';
    }

    /**
     * Determine whether the user can view the lesson.
     */
    public function view(User $user, Lesson $lesson): bool
    {
        if ($user->role === 'teacher') {
            return $lesson->section->teacher_id === $user->profile->id;
        }

        if ($user->role === 'student') {
            return $lesson->section->students()->where('students.id', $user->profile->id)->exists();
        }

        return false;
    }

    /**
     * Determine whether the user can create lessons.
     */
    public function create(User $user): bool
    {
        return $user->role === 'teacher';
    }

    /**
     * Determine whether the user can update the lesson.
     */
    public function update(User $user, Lesson $lesson): bool
    {
        if ($user->role === 'teacher') {
            return $lesson->section->teacher_id === $user->profile->id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the lesson.
     */
    public function delete(User $user, Lesson $lesson): bool
    {
        if ($user->role === 'teacher') {
            return $lesson->section->teacher_id === $user->profile->id;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the lesson.
     */
    public function restore(User $user, Lesson $lesson): bool
    {
        if ($user->role === 'teacher') {
            return $lesson->section->teacher_id === $user->profile->id;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the lesson.
     */
    public function forceDelete(User $user, Lesson $lesson): bool
    {
        if ($user->role === 'teacher') {
            return $lesson->section->teacher_id === $user->profile->id;
        }

        return false;
    }
}
