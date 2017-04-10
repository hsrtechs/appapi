<?php

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class InstallLog extends Model
{

    public $timestamps = true;
    protected $table = 'install_logs';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
