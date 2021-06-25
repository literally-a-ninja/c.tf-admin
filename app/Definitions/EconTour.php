<?php

namespace App\Definitions;

use App\Database\Schema\Definition;
use Illuminate\Support\Collection;

/**
 * Class Tour
 *
 * @package App\Definitions
 */
class EconTour extends Definition
{
    /**
     * "tour_name": "Platinum Palliative",
     * "description": "This tour contains 16 advanced missions across 13 maps, each with minor gameplay changes, additions, and/or a pure vanilla experience. In this tour you will find Custom Tanks, and Robot Changes.",
     * "difficulty": 3,
     *
     * "mission_complete_loot_list": "mvm_victory",
     * "tour_complete_loot_list": "mvm_victory_directive",
     *
     * "mission_complete_campaign_name": "mvm_directive",
     * "mission_complete_campaign_points": 50,
     */

    /**
     * @var string
     */
    protected string $location = 'economy/mvm/tours.json';

    /**
     * @return Collection
     */
    function missions () : Collection
    {
        if (! isset($this->contents['missions'])) {
            return collect ();
        }

        $missions = collect ();
        foreach ($this->contents['missions'] as $mission) {
            $object = new EconMission();
            $object->contents = $mission;
            foreach ($mission as $k => $v) {
                $object->$k = $v;
            }
            $missions->push ($object);
        }

        return $missions;
    }
}
