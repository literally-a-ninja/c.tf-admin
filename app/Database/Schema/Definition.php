<?php

namespace App\Database\Schema;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\Pure;

/**
 * Denotes a type of database object which is immutable.
 *
 * @package App\
 */
class Definition implements Arrayable, Jsonable
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
    protected $id = '';

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
    protected $contents = [];

    public function __construct (
        protected Filesystem $filesystem
    ) {
    }

    /**
     * Returns a collection of all definitions within this file.
     * @return Collection
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function all () : Collection
    {
        return $this->disk ()
            ->map (function ($data) {
                $c = new static($this->filesystem);
                $c->fill ($data);
                return $c;
            });

    }

    /**
     * Reads from disk.
     *
     * @return Collection
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function disk () : Collection
    {
        $contents = $this->filesystem->get ($this->location);
        return collect (json_decode ($contents, true));
    }

    /**
     * @param  array|Arrayable  $arr
     */
    public function fill (array|Arrayable $arr)
    {
        $this->contents = is_array ($arr) ? $arr : $arr->toArray ();
        foreach ($this->contents as $k => $v) {
            $this->$k = $v;
        }
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
     * @return string
     */
    public function getDisk () : string
    {
        return $this->disk;
    }

    /**
     * @return array
     */
    public function getContents () : array
    {
        return $this->contents;
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function grabFromDisk () : Definition
    {
        $member = $this->locate ($this->disk ());
        $this->fill ($member);
        return $this;
    }

    /**
     * Applies any necessary transformations to obtain our data.
     *
     * @param  array  $original
     *
     * @return array
     */
    protected function locate (Collection $original) : array
    {
        try {
            if (! empty($this->memberKey)) {

                return $original->firstWhere ($this->memberKey, $this->id);
            }

            if (! empty($this->id)) {
                return $original->get ($this->id);
            }
            return $original;
        } catch (\ErrorException $error) {
            // This exception confirms better to what we're doing plus this will create a 404 if unhandled.
            throw new RecordsNotFoundException("$this->id not found.");
        }
    }

    /**
     * Create a new instance of the given definition.
     *
     * @param  string  $key
     * @return static
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    #[Pure] public function newInstance (string $key = '') : Definition
    {
        $model = new static();
        $model->id = $key;

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
