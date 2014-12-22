<?php namespace Zbw\Airports;

use Illuminate\Database\Eloquent\Model;

class Frequency extends Model
{
    protected $table = 'airport_frequencies';

    protected $guarded = ['id'];
    public $timestamps = false;

    public function airport()
    {
        return $this->belongsTo(Airport::class, 'icao', 'icao');
    }
}
