<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use function number_format;

class CreditLog extends Model
{

    public $timestamps = true;

    protected $table = 'credit_logs';

    protected $hidden = [
        'id', 'user_id', 'log_line', 'created_at', 'updated_at', 'value'
    ];

    protected $casts = [
        'credited' => 'boolean',
        'value' => 'float',
        'ip' => 'ip',
        'amount' => 'float'
    ];

    protected $appends = [
        'log', 'date', 'debited', 'amount'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function isCredited()
    {
        return $this->credited;
    }

    public function isDebited()
    {
        return $this->debited;
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = number_format($value, 2);
    }

    public function getValueAttribute($value)
    {
        return number_format($value, 2);
    }

    public function getAmountAttribute($value)
    {
        return $this->value;
    }

    public function getLogAttribute()
    {
        return $this->log_line;
    }

    public function getDateAttribute()
    {
        return $this->created_at;
    }

    public function getDebitedAttribute()
    {
        return !$this->credited;
    }

}
