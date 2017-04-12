<?php

namespace App;

use function bcrypt;
use function encrypt;
use function hash;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use function str_random;
use function strtolower;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    public $timestamps = true;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'number', 'country', 'credits', 'device_id', 'access_token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'access_token', 'device_id', 'updated_at', 'created_at', 'id',
    ];

    protected $casts = [
        'credits' => 'float',
        'verified' => 'boolean',
    ];


    public function isVerified() : boolean
    {
        return $this->verified == true;
    }

    public function addCredits(float $credits)
    {
        $this->credits += $credits;
        return $this->saveOrFail();
    }

    public function deductCredits(float $credits)
    {
        $this->credits -= $credits;
        return $this->saveOrFail();
    }

    public function updateAccessToken()
    {
        $this->access_token = str_random(64);
        return $this->saveOrFail();
    }

    public function updateDeviceId($value)
    {
        $this->device_id = $value;
        return $this->saveOrFail();
    }

    public function installLogs()
    {
        return $this->hasMany('App\InstallLog');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setAccessTokenAttribute($value)
    {
        $this->attributes['access_token'] = ($value);
    }

    public function getAccessTokenAttribute($value)
    {
        return ($value);
    }

    public function setDeviceIdAttribute($value)
    {
        $this->attributes['device_id'] = encrypt($value);
    }


    public function getDeviceIdAttribute($value)
    {
        return decrypt($value);
    }

}
