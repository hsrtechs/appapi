<?php

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class InstallLog extends Model
{

    public $timestamps = true;

    protected $table = 'install_logs';

    protected $hidden = [
        'id', 'type', 'created_at', 'updated_at', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getTypeAttribute($value)
    {
        return $value ? 'Credit' : 'Debit';
    }
}
