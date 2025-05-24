<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

class jadwal extends Model
{
    public $table = 'jadwals';

    public $fillable = [
        'hari',
        'jam',
        'kuota',
        'psikolog_id'
    ];

    protected $casts = [
        'hari' => 'string',
        'jam' => 'string',
        'kuota' => 'integer',
        'psikolog_id' => 'string'
    ];

    public static array $rules = [
        'hari' => 'required',
        'jam' => 'required'
    ];

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d/m/Y');
    }

    public function psikolog()
    {
        return $this->belongsTo(\App\Models\psikolog::class, 'psikolog_id');
    }
    public function konseling()
    {
        return $this->hasMany(\App\Models\konseling::class, 'jadwal_id');
    }

    
}
