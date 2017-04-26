<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class DeviceId extends Model
{

    public $timestamps = true;

    protected $table = 'device_id';

    protected $hidden = ['id', 'updated_at'];

    protected $fillable = ['device_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
