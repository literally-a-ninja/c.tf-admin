<?php

namespace App\Models\Statistic;

use App\Models\Statistic;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class MissionScope extends Statistic implements Scope
{
    public function getMissionNameAttribute()
    {
        preg_match_all('/\[MVMM\:([a-z0-9_]+)/', $this->target, $matches, PREG_SET_ORDER, 0);
        return $matches[1][0];
    }

    public function getMapAttribute()
    {
        preg_match_all('/\[MVMM\:(mvm_[a-z0-9]+)/', $this->target, $matches, PREG_SET_ORDER, 0);
        return $matches[1][0];
    }

    public function waveComplete($number)
    {
        return $this->progress["wave_{$number}"];
    }

    public function waveTime($number)
    {
        return $this->progress["wave_{$number}_duration"];
    }

    public function getLastUpdatedAttribute(): DateTime
    {
        return new DateTime($this->progress["last_updated"] ?? 0);
    }

    public function apply(Builder $builder, Model $model)
    {
        $builder->where('target', 'LIKE', '[MVMM:%');
    }
}
