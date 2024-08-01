<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class Program extends Model
{
    use HasFactory;

    function courses(){
        return $this->belongsToMany(Course::class, 'program_course');
    }
}
