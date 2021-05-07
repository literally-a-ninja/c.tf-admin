<?php

namespace App\Definitions;

use App\Database\Schema\Definition;
use Illuminate\Support\Collection;

class Tour extends Definition
{
    protected $location = 'economy/mvm/tours.json';

    /**
     * @return Collection
     */
    function missions(): Collection
    {
        if (!isset($this->contents['missions']))
        {
            return collect ();
        }

        $missions = collect();
        foreach ($this->contents['missions'] as $mission)
        {
            $object = new Mission();
            $object->contents = $mission;
            foreach ($mission as $k => $v)
            {
                $object->$k = $v;
            }
            $missions->push($object);
        }

        return $missions;
    }
}
