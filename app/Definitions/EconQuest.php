<?php


namespace App\Definitions;


use App\Database\Schema\Definition;
use Illuminate\Support\Collection;

/**
 * Class Quest
 *
 * @package App\Definitions
 *
 * @property-read string $name
 * @property-read string $title
 * @property-read string $image
 * @property-read bool $background
 * @property-read int $difficulty
 * @property-read array $restrictions
 * @property-read array $objectives
 * @property-read array $rewards
 */
class EconQuest extends Definition
{
    /**
     * @var string
     */
    protected string $location = 'economy/contracker/quests.json';

    public function all () : Collection
    {
        return $this->disk ();
    }

    /**
     * Applies any necessary transformations to obtain our data.
     *
     * @param  array  $original
     * @return array
     */
    protected function locate (Collection $original) : array
    {
        return $original
            ->where ('title', $this->id)
            ->first ();
    }

}
