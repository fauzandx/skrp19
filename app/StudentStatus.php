<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentStatus extends Model
{
    use \Staudenmeir\EloquentEagerLimit\HasEagerLimit;

    protected $fillable = [
        'id_ta',
        'nim',
        'status',
        'ipk_terakhir',
    ];

    public function student()
    {
        return $this->belongsTo('App\Student','nim');
    }

    public function academicYear()
    {
        return $this->belongsTo('App\AcademicYear','id_ta');
    }
}
