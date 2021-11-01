<?php

namespace App\Database\Schema;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use JetBrains\PhpStorm\Pure;
use Psr\SimpleCache\InvalidArgumentException;


/**
 * Denotes a type of database object which is immutable.
 *
 * @package App\
 */
class CacheableDefinition extends Definition
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

    #[Pure] public function __construct (Filesystem $filesystem)
    {
        parent::__construct ($filesystem);
    }

    /**
     * @return string
     */
    protected function cacheKey () : string
    {
        if (isset($this->cacheKey))
            return $this->cacheKey;

        $location = md5 ($this->location);

        $this->cacheKey = "def@$location";
        return $this->cacheKey;
    }

    /**
     * Returns a possibly cached collection.
     *
     * @return Collection
     * @throws FileNotFoundException
     */
    protected function read () : Collection
    {

        $key = $this->cacheKey ();

        if (Cache::has ($key))
            return Cache::get ($key);

        $result = parent::read ();
        Cache::put ($key, $result, $this->cachableTTL);

        return $result;
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
     * @throws InvalidArgumentException
     */
    public function cacheRemove () : CacheableDefinition
    {
        Cache::delete ($this->cacheKey);
        return $this;
    }
}
