<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PsikologKuota extends Model
{
    public $table = 'psikolog_kuota';

    public $fillable = [
        'kuota_hari',
        'kuota_bulan',
        'kuota_tahun',
        'bulan',
        'psikolog_id'
    ];

    protected $casts = [
        'kuota_hari' => 'string',
        'kuota_bulan' => 'string',
        'kuota_tahun' => 'string',
        'bulan' => 'integer',
        'psikolog_id' => 'integer'
    ];

    public static array $rules = [
        'psikolog_id' => 'required'
    ];

    
}
