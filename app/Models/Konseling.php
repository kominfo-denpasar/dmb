<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konseling extends Model
{
    public $table = 'konselings';

    public $fillable = [
        'hasil',
        'kesimpulan',
        'saran',
        'berkas_pendukung',
        'status',
        'psikolog_id',
        'mas_id',
        'keluhan_id'
    ];

    protected $casts = [
        'hasil' => 'string',
        'kesimpulan' => 'string',
        'saran' => 'string',
        'berkas_pendukung' => 'string',
        'status' => 'integer',
        'psikolog_id' => 'string',
        'mas_id' => 'string',
        'keluhan_id' => 'string'
    ];

    public static array $rules = [
        
    ];

    
}
