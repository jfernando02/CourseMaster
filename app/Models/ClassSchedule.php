<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class ClassSchedule extends Model
{
    use HasFactory;

    protected $table = 'classSchedule';


    protected $fillable = [
        'offering_id',
        'class_type',
        'start_time',
        'end_time',
        'class_day'
    ];

    public function offering()
    {
        return $this->belongsTo(Offering::class, 'offering_id');
    }

    //A class will usually belong to only one academic, but it isn't mandatory and the belongsToMany functionality is useful
    public function academic()
    {
        return $this->belongsToMany(Academic::class);
    }

    public function findOffering($course_id, $year, $trimester)
    {
        $offering = Offering::where('course_id', $course_id)
            ->where('academic_id', $this->academic_id)
            ->where('year', $year)
            ->where('trimester', $trimester)
            ->first();
        return $offering;
    }
}
