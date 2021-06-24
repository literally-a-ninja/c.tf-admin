<?php


namespace App\Definitions;


use App\Database\Schema\Definition;

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
class Quest extends Definition
{
    /**
     * @var string
     */
    protected string $location = 'economy/contracker/quests.json';

    /**
     * Applies any necessary transformations to obtain our data.
     *
     * @param  array  $quests
     * @return array
     */
    protected function locate(array $quests): array
    {
        return collect ($quests)
            ->where ('title', $this->key)
            ->first ();
    }

}
