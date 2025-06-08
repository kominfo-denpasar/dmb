<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\keluhan;
use App\Models\Konseling;

class Masyarakat extends Model
{
    public $table = 'masyarakats';

    public $fillable = [
        'nik',
        'nama',
        'jk',
        'tgl_lahir',
        'alamat',
        'hp',
        'email',
        'status_kawin',
        'pendidikan',
        'pekerjaan',
        'desa_id',
        'kec_id',
        'user_id',
        'status',
        'token'
    ];

    protected $casts = [
        'nik' => 'string',
        'nama' => 'string',
        'tgl_lahir' => 'date',
        'alamat' => 'string',
        'hp' => 'string',
        'email' => 'string',
        'status_kawin' => 'string',
        'pendidikan' => 'string',
        'pekerjaan' => 'string',
        'desa_id' => 'integer',
        'kec_id' => 'integer',
        'user_id' => 'integer',
        'status' => 'integer',
        'token' => 'string'
    ];

    public static array $rules = [
        'nik' => 'required',
        'nama' => 'required',
        'tgl_lahir' => 'required',
        'hp' => 'required',
        'email' => 'required'
    ];

    public function keluhan()
    {
        return $this->hasMany(keluhan::class, 'mas_id', 'token');
    }

    public function konseling()
    {
        return $this->hasMany(Konseling::class, 'mas_id', 'token');
    }

    
}
