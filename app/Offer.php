<?php

namespace App;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{

    public $timestamps = true;
    protected $table = 'offers';
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
        'validity','package', 'validity'
    ];

    protected $hidden = [
        'validity', 'hidden', 'created_at', 'updated_at', 'valid_until',
    ];

    public function scopeActive($query)
    {
        return $query->where('hidden',false)->whereDate('valid_until', '>=', Carbon::now());
    }

    public function getValidityAttribute()
    {
        return $this->valid_until;
    }


    public function setCountryAttribute($value)
    {
        $this->attributes['country'] = strtolower($value);
    }

    public function getCountryAttribute($value)
    {
        return ucfirst($value);
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
