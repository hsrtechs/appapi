<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

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
        'firstname', 'lastname', 'email', 'number', 'country', 'credits', 'device_id', 'access_token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'access_token','device_id', 'updated_at', 'created_at',
    ];

    protected $casts = [
        'credits' => 'float',
        'verified' => 'boolean',
    ];

    protected $appends = ['name'];

    public function isVerified() : boolean
    {
        return $this->verified == true;
    }

    public function getNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function addCredits(float $credits)
    {
        $this->credits += $credits;
        return $this->saveOrFail();
    }

    public function installLogs()
    {
        return $this->hasMany('App\InstallLog');
    }
}
