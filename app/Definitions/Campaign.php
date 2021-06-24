<?php


namespace App\Definitions;

use App\Database\Schema\Definition;
use DateTime;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;

/**
 * Class Campaign
 *
 * @property-read string $name
 * @property-read string $title
 * @property-read DateTime $start_time
 * @property-read DateTime $end_time
 **/
class Campaign extends Definition
{
    protected string $location = 'economy/contracker/campaigns.json';

    protected string $memberKey = 'title';


    public function fill (array|Arrayable $arr)
    {
        $arr['start_time'] = strtotime ($arr['start_time'] ?? 'now');
        $arr['end_time'] = strtotime ($arr['start_time'] ?? 'now');

        parent::fill ($arr);
    }

    protected function locate (Collection $original) : array
    {
        return $original
            ->where ('title', $this->id)
            ->first ();
    }
}