<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class User
 * @package App\Models
 * @version April 27, 2021, 12:37 am UTC
 *
 * @property string $id
 * @property string $title
 * @property integer $is_html
 * @property string $story
 * @property string $created
 * @property string $published
 * @property string $author
 * @property integer $views
 * @property string $likes
 * @property string $embed
 */
class Post extends Model
{
    use HasFactory;

    public $table = 'tf_posts';

    public $timestamps = false;

    public $fillable = [
        'id',
        'title',
        'is_html',
        'story',
        'created',
        'published',
        'author',
        'views',
        'likes',
        'embed',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'title' => 'string',
        'is_html' => 'integer',
        'story' => 'string',
        'created' => 'string',
        'published' => 'string',
        'author' => 'string',
        'views' => 'integer',
        'likes' => 'string',
        'embed' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'id' => 'required|string|max:18',
        'title' => 'nullable|string|max:32',
        'is_html' => 'nullable|intager',
        'story' => 'nullable|string',
        'created' => 'nullable|string',
        'published' => 'nullable|string',
        'author' => 'nullable|string',
        'views' => 'required|integer',
        'likes' => 'required|integer',
        'embed' => 'nullable|string',
    ];
}
