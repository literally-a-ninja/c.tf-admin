<?php

namespace App\Models\Interpretations;

use App\Models\Statistic;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;

/**
 * Class Campaign
 *
 * @package App\Models
 */
class Campaign extends Statistic
{
    /**
     * @param  array|mixed|string[]  $columns
     * @return Collection|array
     */
    public static function all ($columns = [ '*' ]) : Collection|array
    {
        return Campaign::query ()
            ->where ('target', 'LIKE', '[C:%')
            ->get ();

    }

    /**
     * @param  string  $econName
     * @param  User|null  $user
     * @return array|Collection
     */
    public static function findEcon (string $econName, ?User $user) : array|Collection
    {
        return Campaign::query ()
            ->where ('target', '=', "[C:$econName]")
            ->where ('steamid', '=', $user->steamid)
            ->get ();
    }
}
