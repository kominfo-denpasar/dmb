<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class keluhan extends Model
{
    public $table = 'keluhans';

    public $fillable = [
        'Keluhan',
        'waktu_kapan',
        'nilai_mengganggu',
        'jadwal_id',
        'mas_id',
        'psikolog_id'
    ];

    protected $casts = [
        'Keluhan' => 'string',
        'waktu_kapan' => 'string',
        'nilai_mengganggu' => 'integer',
        'jadwal_id' => 'integer',
        'mas_id' => 'string',
        'psikolog_id' => 'string'
    ];

    public static array $rules = [
        'Keluhan' => 'required',
        'waktu_kapan' => 'required',
        'nilai_mengganggu' => 'required',
        'jadwal_id' => 'required',
        'mas_id' => 'required'
    ];

    
}
