<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teest extends Model
{
    protected $table = 'teest';

    protected $fillable = [
        'uuid',
        'connection',
        'queue',
        'payload',
        'exception',
        'failed_at',
    
    ];
    
    
    protected $dates = [
        'failed_at',
    
    ];
    public $timestamps = false;
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/teests/'.$this->getKey());
    }
}
