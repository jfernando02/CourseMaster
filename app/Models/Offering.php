<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offering extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'trimester',
        'campus',
        'year',
        'note',
    ];

    // function convenor(){
    //     return $this->belongsTo('App\Models\Academic', 'academic_id');
    // }

    function course(){
        // return $this->belongsTo('App\Models\Course', 'course_id');
        return $this->belongsTo(Course::class, 'course_id');
    }

    function academics(){
        return $this->belongsToMany(Academic::class);
    }

    function classSchedules(){
        return $this->hasMany('App\Models\ClassSchedule', 'offering_id');
    }
}
