<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Item
 * @package App\Models
 * @version April 27, 2021, 12:37 am UTC
 *
 * @property string $steamid
 * @property integer $defid
 * @property integer $quality
 * @property string $attributes
 * @property string $hash
 * @property integer $slot
 */
class Item extends Model
{

    use HasFactory;

    public $table = 'tf_pack';
    
    public $timestamps = false;




    public $fillable = [
        'steamid',
        'defid',
        'quality',
        'attributes',
        'hash',
        'slot'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'steamid' => 'string',
        'defid' => 'integer',
        'quality' => 'integer',
        'attributes' => 'string',
        'hash' => 'string',
        'slot' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'steamid' => 'required|string|max:64',
        'defid' => 'required|integer',
        'quality' => 'required|integer',
        'attributes' => 'nullable|string',
        'hash' => 'nullable|string|max:255',
        'slot' => 'required|integer'
    ];

    
}
