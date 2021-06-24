<?php


namespace App\Definitions;

use App\Database\Schema\Definition;
use DateTime;
use Illuminate\Contracts\Support\Arrayable;

/**
 * Class Campaign
 *
 * @property-read string $name
 * @property-read string $title
 * @property-read DateTime $start_time
 * @property-read DateTime $end_time
 */
class Campaign extends Definition
{
    protected string $location = 'economy/contracker/campaigns.json';

    public function fill (array|Arrayable $arr)
    {
        $arr['start_time'] = strtotime ($arr['start_time'] ?? 'now');
        $arr['end_time'] = strtotime ($arr['start_time'] ?? 'now');

        parent::fill ($arr);
    }

    protected function locate (array $original) : array
    {
        return collect ($original)
            ->where ('title', $this->key)
            ->first ();
    }
}