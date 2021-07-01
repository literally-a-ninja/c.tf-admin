<?php

namespace App\Database\Schema;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;

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
    ) {
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
     * Generic find method checked member key if specified, otherwise uses the direct id.
     * This is used by Eloquent to associate models to econ definitions.
     *
     * @param $value
     * @return mixed
     * @throws FileNotFoundException
     */
    public function find ($value) : mixed
    {
        if (empty($value))
            return NULL;

        return empty($this->memberKey)
            ? $this->findById ($value)
            : $this->findByKey ($value);
    }

    /**
     * @return Definition
     * @throws FileNotFoundException
     */
    public function findById ($id) : mixed
    {
        return $this->newInstance ($id)
            ->fill ($this->all ()->get ($id));
    }

    /**
     * @param  array|Arrayable  $arr
     * @return Definition
     */
    public function fill (
        array|Arrayable $arr
    ) : Definition {
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
     * @return Definition
     */
    #[Pure] public function newInstance (string $id = '') : Definition
    {
        $model = new static($this->filesystem);
        $model->id = $id;

        return $model;
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
        return collect (json_decode ($contents, true))
            ->map (function ($model, $id) {
                $model['id'] = $model['id'] ?? $id;
                return $model;
            });
    }

    /**
     * @throws FileNotFoundException
     */
    public function findByKey ($value, $key = false) : ?Definition
    {
        return $this
            ->all ()
            ->firstWhere ($key ?: $this->memberKey, $value);
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
