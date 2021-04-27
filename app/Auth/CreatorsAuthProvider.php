<?php

namespace App\Auth;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CreatorsAuthProvider implements UserProvider
{
    /**
     * @param mixed $identifier
     *
     * @return null|Authenticatable|Builder|Model|object
     */
    public function retrieveById($identifier)
    {
        return User::query()
            ->where('id', '=', $identifier)
            ->first();
    }

    /**
     * @param mixed $identifier
     *
     * @return null|Authenticatable|Builder|Model|object
     */
    public function retrieveByToken($identifier, $token)
    {
        return User::query()
            ->where('id', '=', $identifier)
            ->where('token', '=', $token)
            ->first();
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        return $user;
        // Unimplemented
    }

    /**
     * @param mixed $identifier
     *
     * @return null|Authenticatable|Builder|Model|object
     */
    public function retrieveByCredentials(array $credentials)
    {
        // TODO: Change this.
        $alias = $credentials['alias'];
        return User::query()
            ->where('alias', '=', $alias)
            ->first();
    }

    public function validateCredentials(Authenticatable $user, array $credentials): bool
    {
        return isset($user);
    }
}
