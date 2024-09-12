<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cotaught;
use App\Models\Program;
use App\Models\Academic;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'prereq', 'transition', 'note'];

    function offerings(){
        return $this->hasMany('App\Models\Offering');
    }

    function cotaught(){
        $cotaughts = Cotaught::where('course_id', $this->id)->get();
        // dd($cotaughts);
        $cotaughts_arr = [];
        foreach ($cotaughts as $cotaught_obj){
            $cotaught_id = $cotaught_obj->co_taught_id;
            $cotaughts_arr[] = Course::find($cotaught_id);
        }
        return $cotaughts_arr;
    }

    function programs(){
        return $this->belongsToMany(Program::class, 'program_course');
    }

    function academic()
    {
        return $this->belongsTo(Academic::class, 'academic_id');
    }
}
