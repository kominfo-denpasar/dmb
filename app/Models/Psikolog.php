<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Psikolog extends Model
{
    public $table = 'psikologs';

    public $fillable = [
        'nik',
        'kta',
        'sipp',
        'nama',
        'jk',
        'hp',
        'alamat_rumah',
        'alamat_praktek',
        'foto',
        'kec_id',
        'desa_id',
        'ttd',
        'user_id',
        'status'
    ];

    protected $casts = [
        'nik' => 'string',
        'kta' => 'string',
        'sipp' => 'string',
        'nama' => 'string',
        'jk' => 'string',
        'hp' => 'string',
        'alamat_rumah' => 'string',
        'alamat_praktek' => 'string',
        'foto' => 'string',
        'kec_id' => 'string',
        'desa_id' => 'string',
        'ttd' => 'string',
        'user_id' => 'integer',
        'status' => 'string'
    ];

    public static array $rules = [
        'nama' => 'required',
        'hp' => 'required',
        'alamat_praktek' => 'required'
    ];

    
}
