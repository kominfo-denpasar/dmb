<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

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

    public function jadwal()
    {
        return $this->hasMany(\App\Models\jadwal::class);
    }

    public function setNikAttribute($value)
    {
        $this->attributes['nik'] = Crypt::encryptString($value);
    }

    public function getNikAttribute($value)
    {
        // jika value kosong, kembalikan null
        if (!$value) return null;

        try {
            return Crypt::decryptString($value);
        } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
            // Jika dekripsi gagal, kembalikan null
            return null;
        }
    }

    
}
