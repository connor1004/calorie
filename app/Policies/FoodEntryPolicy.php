<?php

namespace App\Policies;

use App\Models\FoodEntry;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FoodEntryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view all models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAll(User $user)
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FoodEntry  $foodEntry
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, FoodEntry $foodEntry)
    {
        return $user->role == 'admin' || $user->id == $foodEntry->taken_by;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        $request = request();

        return $user->role == 'admin' || $user->id == $request->taken_by;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FoodEntry  $foodEntry
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, FoodEntry $foodEntry)
    {
        return $user->role == 'admin' || $user->id == $foodEntry->taken_by;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FoodEntry  $foodEntry
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, FoodEntry $foodEntry)
    {
        return $user->role == 'admin' || $user->id == $foodEntry->taken_by;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FoodEntry  $foodEntry
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, FoodEntry $foodEntry)
    {
        return $user->role == 'admin' || $user->id == $foodEntry->taken_by;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\FoodEntry  $foodEntry
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, FoodEntry $foodEntry)
    {
        return false;
    }
}
