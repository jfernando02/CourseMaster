<?php

namespace App\Models;

use App\Models\Offering;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class Academic extends Model
{
    use HasFactory;

    protected $fillable = ['firstname', 'lastname', 'teaching_load', 'area', 'note', 'home_campus'];

    //an academic can have many offerings as convenor
    function offerings(){
        return $this->belongsToMany(Offering::class);
    }


    //an academic can have many courses
    function course()
    {
        // return $this->belongsToMany('App\Models\Course', 'id');
        return $this->hasMany(Course::class, 'academic_id', 'course_id');
    }


    //an academic can have many class schedules
    function classSchedules()
    {
        return $this->hasMany(ClassSchedule::class, 'academic_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'email', 'email');
    }


    // Calculate the total teaching hours for an academic in a specified year and trimester
    // If trimester is 0, will get classes for whole year
    public function teachingHours($academicID, $year, $trimester = 0)
    {
        // Get list of class schedules for the academic
        $classSchedules = ClassSchedule::where('academic_id', $academicID)->get();

        // Initialize total teaching hours
        $totalTeachingHours = 0;

        // Loop through each class schedule
        foreach ($classSchedules as $classSchedule) {
            if($trimester == 0){
                $offering = Offering::where('id', $classSchedule->offering_id)
                    ->where('year', $year)
                    ->first();
            }
            // Get the associated offering for the class schedule to check if it is for the specified year and trimester
            else {
                $offering = Offering::where('id', $classSchedule->offering_id)
                    ->where('year', $year)
                    ->where('trimester', $trimester)
                    ->first();
            }

            // If offering exists for the specified year and trimester, add to total teaching hours
            if ($offering) {
                // Calculate teaching hours for the class schedule
                $startTime = strtotime($classSchedule->start_time);
                $endTime = strtotime($classSchedule->end_time);
                $teachingHours = ($endTime - $startTime) / 3600; // Convert seconds to hours

                $totalTeachingHours += $teachingHours;
            }
        }
        // workloadMultiplier is the number of weeks in a trimester to get the total teaching hours for the trimester
        $workloadMultiplier = 12;

        // Optionally, round the total teaching hours to 2 decimal places
        $totalTeachingHours = round($totalTeachingHours, 2) * $workloadMultiplier;

        return $totalTeachingHours;
    }

    public function workloadStatus($academicID, $totalTeachingHours, $yearOrTrimester = "trimester"): string
    {
        $academic = Academic::find($academicID);
        $setting = Setting::latest()->first();
        if($yearOrTrimester=="trimester") {
            if ($academic && $academic->teaching_load) {
                if ($totalTeachingHours > $academic->teaching_load * ($setting->threshold_trimester / 100)) {
                    return "(OW)";
                } elseif ($totalTeachingHours < $academic->teaching_load * ($setting->underwork_threshold_trimester / 100)) {
                    return "(UW)";
                }
            }
        }
        else{
            if ($academic && $academic->yearly_teaching_load) {
                if ($totalTeachingHours > $academic->yearly_teaching_load * ($setting->threshold_year / 100)) {
                    return "(OW)";
                } elseif ($totalTeachingHours < $academic->yearly_teaching_load * ($setting->underwork_threshold_year / 100)) {
                    return "(UW)";
                }
            }
        }
        return "";
    }


}
