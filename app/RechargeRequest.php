<?php

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class RechargeRequest extends Model
{

    public $timestamps = true;
    protected $table = 'request_recharge';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $casts = [
        'recharge' => 'int',
        'approved' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
