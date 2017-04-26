<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Laravel\Lumen\Auth\Authorizable;
use function bcrypt;
use function getReferralCredits;
use function password_verify;
use function str_random;
use function strtolower;
use function ucfirst;

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
        'name', 'email', 'number', 'country', 'credits', 'device_id', 'access_token', 'referral_token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'access_token', 'device_id', 'updated_at', 'created_at', 'id', 'password', 'user_id', 'password_reset'
    ];

    protected $casts = [
        'credits' => 'float',
        'verified' => 'boolean',
    ];

    protected $appends = [
        'ref'
    ];


    public function isVerified() : boolean
    {
        return $this->verified == true;
    }

    public function deductCredits(float $credits)
    {
        $this->credits -= $credits;
        return $this->saveOrFail();
    }

    public function setReferral($code)
    {
        $credits = getReferralCredits();

        $user = self::where('referral_token', $code)->first();
        $user->addReferralCredits($this->name);

        $t = new CreditLog;
        $t->user_id = $this->id;
        $t->value = $credits;
        $t->ip = Request::ip();
        $t->log_line = 'Credits added for referral by: ' . $user->name . '.';
        $t->saveOrFail();

        return $this->addCredits($credits);
    }

    public function addCredits(float $credits)
    {
        $this->credits += $credits;
        return $this->saveOrFail();
    }

    public function addReferralCredits($user)
    {
        $credits = getReferralCredits();

        $t = new CreditLog;
        $t->user_id = $this->id;
        $t->value = $credits;
        $t->ip = Request::ip();
        $t->log_line = 'Credits added for referral to: ' . $user . '.';
        $t->saveOrFail();

        $this->addCredits($credits);

        $this->saveOrFail();
    }

    public function verifyPassword($password = '')
    {
        return password_verify($password, $this->password);
    }

    public function updateAccessToken()
    {
        $this->access_token = str_random(64);
        return $this->saveOrFail();
    }

    public function updateDeviceId($value)
    {
        if ($this->device_id != $value) {
            if (is_null(DeviceId::where('device_id', $this->device_id)->first())) {
                DeviceId::create(['device_id' => $this->device_id, 'user_id' => $this->id]);
            }
            $this->device_id = $value;
            return $this->saveOrFail();

        } else
            return true;
    }

    public function DeviceID()
    {
        return $this->belongsTo('App\DeviceId');
    }

    public function referralBy()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function referral()
    {
        return $this->hasMany('App\User', 'id', 'user_id');
    }

    public function installLogs()
    {
        return $this->hasMany('App\InstallLog');
    }

    public function creditLogs()
    {
        return $this->hasMany('App\CreditLog');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setAccessTokenAttribute($value)
    {
        $this->attributes['access_token'] = ($value);
    }

    public function setCountryAttribute($value)
    {
        $this->attributes['country'] = strtolower($value);
    }

    public function getCountryAttribute($value)
    {
        return ucfirst($value);
    }

    public function getAccessTokenAttribute($value)
    {
        return ($value);
    }

    public function setDeviceIdAttribute($value)
    {
        $this->attributes['device_id'] = ($value);
    }


    public function getDeviceIdAttribute($value)
    {
        return ($value);
    }

    public function getRefAttribute()
    {
        return self::where('id', $this->user_id)->pluck('name')->first();
    }

    public function changePassword($password)
    {
        $this->password = $password;
        return $this->saveOrFail() ? $password : false;
    }

    public function toggleVerified()
    {
        $this->verified = !$this->verified;
        return $this->saveOrFail();
    }

    public function generatePasswordResetlink()
    {
        $id = encrypt($this->id);
        $token = $this->updatePasswordResetToken();
        return route('reset.email', ['id' => $id, 'token' => $token], true);
    }

    public function updatePasswordResetToken($token = NULL)
    {
        $token = $token ?? str_random(8);
        $token = sha1($token);

        $this->password_reset = ($token);

        return $this->saveOrFail() ? $token : false;

    }

    public function compareResetToken($token)
    {
        return $this->password_reset == $token;
    }

}
