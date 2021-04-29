<?php

namespace App\Models;

use Eloquent as Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class User
 * @package App\Models
 * @version April 27, 2021, 12:37 am UTC
 *
 * @property string $steamid
 * @property string $alias
 * @property string $name
 * @property string $motd
 * @property string $avatar
 * @property string $token
 * @property integer $bans
 * @property integer $special
 * @property integer $admin
 * @property string $connections
 * @property string $loadout
 * @property string $settings
 * @property integer $queried
 * @property integer $exp
 * @property integer $credit
 * @property integer $contract
 * @property string $owner
 * @property string $lastlogin
 * @property string $lastserver
 * @property integer $backpack_pages
 * @property string $presence
 */
class User extends Model
{
    use HasFactory;

    public $table = 'tf_users';

    public $timestamps = false;

    public $fillable = [
        'steamid',
        'alias',
        'name',
        'motd',
        'avatar',
        'token',
        'bans',
        'special',
        'admin',
        'connections',
        'loadout',
        'settings',
        'queried',
        'exp',
        'credit',
        'contract',
        'owner',
        'lastlogin',
        'lastserver',
        'backpack_pages',
        'presence',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'steamid' => 'string',
        'alias' => 'string',
        'name' => 'string',
        'motd' => 'string',
        'avatar' => 'string',
        'token' => 'string',
        'bans' => 'integer',
        'special' => 'integer',
        'admin' => 'integer',
        'connections' => 'string',
        'loadout' => 'string',
        'settings' => 'string',
        'queried' => 'integer',
        'exp' => 'integer',
        'credit' => 'integer',
        'contract' => 'integer',
        'owner' => 'string',
        'lastlogin' => 'string',
        'lastserver' => 'string',
        'backpack_pages' => 'integer',
        'presence' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'steamid' => 'required|string|max:18',
        'alias' => 'nullable|string|max:32',
        'name' => 'nullable|string|max:256',
        'motd' => 'nullable|string',
        'avatar' => 'nullable|string',
        'token' => 'nullable|string|max:512',
        'bans' => 'nullable|integer',
        'special' => 'required|integer',
        'admin' => 'required|integer',
        'connections' => 'nullable|string',
        'loadout' => 'nullable|string',
        'settings' => 'nullable|string',
        'queried' => 'nullable|integer',
        'exp' => 'required|integer',
        'credit' => 'required|integer',
        'contract' => 'required|integer',
        'owner' => 'nullable|string',
        'lastlogin' => 'nullable|string|max:255',
        'lastserver' => 'nullable|string|max:255',
        'backpack_pages' => 'nullable|integer',
        'presence' => 'nullable|string',
    ];
}
