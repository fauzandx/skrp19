<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    protected $primaryKey = 'kd_prodi';
    protected $fillable = [
                        'kd_prodi',
                        'kd_jurusan',
                        'nama',
                        'singkatan',
                        'jenjang',
                        'no_sk',
                        'tgl_sk',
                        'pejabat_sk',
                        'thn_menerima',
                        'nip_kaprodi',
                        'nm_kaprodi',
                    ];

    public function department()
    {
        return $this->belongsTo('App\Department','kd_jurusan');
    }

    public function collaboration()
    {
        return $this->hasMany('App\Collaboration','kd_prodi');
    }

    public function teacher()
    {
        return $this->hasMany('App\Teacher','kd_prodi');
    }

    public function student()
    {
        return $this->hasMany('App\Student','kd_prodi');
    }

    public function studentQuota()
    {
        return $this->hasMany('App\StudentQuota','kd_prodi');
    }

    public function funding()
    {
        return $this->hasMany('App\Funding','kd_prodi');
    }

    public function curriculum()
    {
        return $this->hasMany('App\Curriculum','kd_prodi');
    }
}
