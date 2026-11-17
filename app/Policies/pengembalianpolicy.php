<?php

namespace App\Policies;

use App\Models\User;
use App\Models\pengembalian;
use Illuminate\Auth\Access\Response;

class pengembalianpolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, pengembalian $pengembalian): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $pengguna, pengembalian $pengembalian): bool
    {
        return $pengguna->can('pengembalian.kelola');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, pengembalian $pengembalian): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, pengembalian $pengembalian): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, pengembalian $pengembalian): bool
    {
        return false;
    }
}
