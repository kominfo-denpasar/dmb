<?php

namespace App\Repositories;

use App\Models\Masyarakat;
use App\Repositories\BaseRepository;

class MasyarakatRepository extends BaseRepository
{
    protected $fieldSearchable = [
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

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Masyarakat::class;
    }
}
