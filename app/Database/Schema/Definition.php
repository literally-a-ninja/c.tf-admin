<?php

namespace App\Database\Schema;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\Pure;

/**
 * Denotes a type of database object which is immutable.
 *
 * @package App\
 */
abstract class Definition implements Arrayable, Jsonable
{
    /**
     * Where is this definition located?
     *
     * @var string
     */
    protected string $location;

    /**
     * The key/name of a definition.
     *
     * @var string
     * @default ''
     */
    protected string $id = '';

    /**
     * Unique identifier each member has.
     * If not empty, $memberKey will be treated as key to $id.
     *
     * @var string
     * @default ''
     */
    protected string $memberKey = '';

    /**
     * The contents of a definition.
     *
     * @var array
     * @default an empty array
     */
    protected array $contents = [];

    public function __construct (
        protected Filesystem $filesystem
    )
    {
    }

    /**
     * @return string
     */
    public function getLocation () : string
    {
        return $this->location;
    }

    /**
     * @return string
     */
    public function getId () : string
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getContents () : array
    {
        return $this->contents;
    }

    /**
     * @throws FileNotFoundException
     */
    public function findById ($id) : ?CachableDefinition
    {
        $all = $this->all ();
        if (! empty($this->memberKey)) {
            return $all->firstWhere ($this->memberKey, $id);
        }

        if (! empty($this->id)) {
            return $all->get ($id);
        }

        return NULL;
    }

    /**
     * Returns a collection of all definitions within this file.
     *
     * @return Collection
     * @throws FileNotFoundException
     */
    public function all () : Collection
    {
        return $this->read ()
            ->map (function ($data) {
                $c = new static($this->filesystem);
                $c->fill ($data);
                return $c;
            });

    }

    /**
     * Reads and parse data.
     *
     * @return Collection
     * @throws FileNotFoundException
     */
    protected function read () : Collection
    {
        $contents = $this->filesystem->get ($this->location);
        return collect (json_decode ($contents, true));
    }

    /**
     * @param  array|Arrayable  $arr
     */
    public function fill (array|Arrayable $arr) : Definition
    {
        $this->contents = is_array ($arr) ? $arr : $arr->toArray ();
        foreach ($this->contents as $k => $v) {
            $this->$k = $v;
        }

        return $this;
    }

    /**
     * Create a new instance of the given definition.
     *
     * @param  string  $id
     * @return static
     * @throws FileNotFoundException
     */
    #[Pure] public function newInstance (string $id = '') : CachableDefinition
    {
        $model = new static($this->filesystem);
        $model->id = $id;

        return $model;
    }

    /**
     * @return array
     */
    public function toArray () : array
    {
        return $this->contents;
    }

    /**
     * @param  int  $options
     *
     * @return string
     */
    public function toJson ($options = 0) : string
    {
        return json_encode ($this->contents, $options);
    }
}
