<?php

namespace App\Database\Schema;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;


/**
 * Denotes a type of database object which is immutable.
 *
 * @package App\
 */
class CachableDefinition extends Definition
{
    /**
     * Definition's cache key where all parameters are hashed via MD5.
     *
     * format 'def@{location}'
     *
     * @var string
     */
    protected string $cacheKey;

    /**
     * How long to keep this object in cache.
     *
     * @var int TTL in seconds (default: 3 days)
     */
    protected int $cachableTTL = 259200;

    public function __construct (Filesystem $filesystem)
    {
        parent::__construct ($filesystem);

        $location = md5 ($this->location);
        $this->cacheKey = "def@{$location}";
    }

    /**
     * @return string
     */
    public function getCacheKey () : string
    {
        return $this->cacheKey;
    }

    /**
     * Removes an object from cache.
     *
     * @return $this
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function cacheRemove () : CachableDefinition
    {
        Cache::delete ($this->cacheKey);
        return $this;
    }

    /**
     * Returns a possibly cached collection.
     *
     * @return Collection
     * @throws FileNotFoundException
     */
    protected function read () : Collection
    {
        if (Cache::has ($this->cacheKey))
            return Cache::get ($this->cacheKey);

        $result = parent::read ();
        Cache::put ($this->cacheKey, $result, $this->cachableTTL);

        return $result;
    }
}
