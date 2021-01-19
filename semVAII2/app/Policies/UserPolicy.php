<?php

namespace App\Policies;

use App\Models\Cottage;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function view(User $user)
    {
        $cottageinsertions = DB::table('cottage')->where('owner',Auth::user()->email)->get();
        if (count($cottageinsertions) > 0) return true;
        else return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return Auth::user()->email == 'admin@admin.com';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Cottage $model
     * @return mixed
     */
    public function update(User $user, string $owner)
    {
        if(Auth::user()->name == 'admin') return true;
        else if(Auth::user()->email == $owner) return true;
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        return true;
    }
}
