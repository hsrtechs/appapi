<?php

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{

    protected $table = 'offers';

    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'url', 'image_location', 'package_id', 'credits', 'country', 'desc', 'hidden'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    protected $casts = [
        'credits' => 'float',
        'hidden' => 'boolean',
        'validity' => 'date',
        'valid_until' => 'date',
    ];

    protected $appends = [
        'validity','package'
    ];

    public function scopeActive($query)
    {
        return $query->where('hidden',false)->whereDate('valid_until', '>=', Carbon::now());
    }

    public function getValidityAttribute()
    {
        return $this->valid_until;
    }

    public function getPackageAttribute()
    {
        return $this->package_id;
    }
    public function getImgAttribute()
    {
        return $this->image_location;
    }
}
