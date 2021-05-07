<?php

namespace App\Database\Schema;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\RecordsNotFoundException;
use Illuminate\Support\Facades\Storage;
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
    protected $location;

    /**
     * The key/name of a definition.
     *
     * @var string
     * @default ''
     */
    protected $key = '';

    /**
     * The disk this defintion is located on.
     *
     * @var string
     * @default 'local-def'
     */
    protected $disk = 'local-def';

    /**
     * The contents of a definition.
     *
     * @var array
     * @default an empty array
     */
    protected $contents = [];

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function loadFromDisk(): Definition
    {
        $contents = Storage::disk($this->disk)->get($this->location);
        $contents = json_decode($contents, true);
        $this->contents = $this->transform($contents);

        return $this;
    }

    /**
     * Applies any necessary transformations to obtain our data.
     *
     * @param array $original
     *
     * @return array
     */
    protected function transform(array $original): array
    {
        try
        {
            if (!empty($this->key))
            {
                return $original[$this->key];
            }
            return $original;
        }
        catch (\ErrorException $error)
        {
            // This exception confirms better to what we're doing plus this will create a 404 if unhandled.
            throw new RecordsNotFoundException("$this->key not found.");
        }
    }

    /**
     * Create a new instance of the given definition.
     *
     * @param  string  $key
     * @return static
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    #[Pure] public function newInstance(string $key = '') : Definition
    {
        $model = new static();
        $model->key = $key;

        return $model;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->contents;
    }

    /**
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0): string
    {
        return json_encode($this->contents, $options);
    }

    /**
     * @param  Arrayable  $arr
     */
    public function fill(Arrayable $arr)
    {
        $this->contents = $arr->toArray ();
        foreach ($this->contents as $k => $v)
        {
            $this->$k = $v;
        }
    }
}
