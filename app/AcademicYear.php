<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $fillable = [
                    'tahun_akademik',
                    'semester',
                    'status'
                ];

    public function collaboration()
    {
        return $this->hasOne('App\Collaboration','id_ta');
    }

    public function ewmp()
    {
        return $this->hasMany('App\Ewmp','id_ta');
    }

    public function curriculumSchedule()
    {
        return $this->hasMany('App\CurriculumSchedule','id_ta');
    }

    public function student()
    {
        return $this->hasMany('App\Student','masuk_ta');
    }

    public function studentQuota()
    {
        return $this->hasMany('App\StudentQuota','id_ta');
    }

    public function funding()
    {
        return $this->hasMany('App\Funding','id_ta');
    }

    public function research()
    {
        return $this->hasMany('App\Research','id_ta');
    }
}
