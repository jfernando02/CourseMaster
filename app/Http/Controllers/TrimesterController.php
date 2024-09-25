<?php

namespace App\Http\Controllers;
use App\Models\Academic;
use App\Models\Course;
use App\Models\Cotaught;
use App\Models\Program;
use App\Models\Offering;
use App\Models\ClassSchedule;
use App\Models\Setting;

use App\Http\Controllers\AcademicController;


use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TrimestersImport;
use App\Exports\TrimestersExport;

class TrimesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Using the Eloquent model
        // truncate offers and class
        // ClassSchedule::truncate();
        // Offering::truncate();

        $trimester_number = DB::table('offerings')->
        select('year', 'trimester AS tri')->
        groupBy('year', 'tri')->
        get();


        // get all trimester the year + trimester
        $trimester_combinations = [];
        foreach ($trimester_number as $item) {
            $trimester_combinations[] = [$item->year, $item->tri];
        }


        $currentTrimesterLength = count($trimester_combinations);
        $currentTrimester = $trimester_combinations[$currentTrimesterLength - 1];
        // dd($trimester_combinations);

        if ($request->input('year') === null) {
            $year = DB::table('offerings')->min('year');
            $trimester = DB::table('offerings')->min('trimester');
        } else {
            $year = $request->input('year');
            $trimester = $request->input('trimester');
        }


            // Find the index of the current trimester in the array
        $current_index = array_search([$year, $trimester], $trimester_combinations);

        // Calculate the index of the previous and next trimesters
        $prev_index = max(0, $current_index - 1);
        $next_index = min(count($trimester_combinations) - 1, $current_index + 1);

        // Get the previous and next trimesters
        $prev_trimester = $trimester_combinations[$prev_index];
        $next_trimester = $trimester_combinations[$next_index];
        $currentTrimester = $trimester_combinations[$current_index];

        $offerings = DB::table('offerings')
        ->join('classSchedule', 'offerings.id', '=', 'classSchedule.offering_id')
        ->join('courses', 'offerings.course_id', '=', 'courses.id')
        ->select('offerings.*', 'classSchedule.*', 'courses.code as course_code', 'courses.name as course_name')
        ->where('offerings.year', $year)
        ->where('offerings.trimester', $trimester)
        ->get();


        $courses = Course::all()->unique('code');
        $academics = Academic::all()->unique('id');
        $campuses = ['GC', 'NA', 'OL'];
        $class_types = ['Lecture', 'Workshop'];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        // dd($trimester_number);


        return view('trimester.index', compact('currentTrimester', 'days', 'class_types', 'campuses', 'year', 'trimester', 'offerings', 'courses', 'academics', 'trimester_number', 'prev_trimester', 'next_trimester'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $setting = Setting::latest()->first();
        $threshold_trimester = $setting ? $setting->threshold_trimester : null;

        $trimester_number = DB::table('offerings')->
        select('year', 'trimester AS tri')->
        groupBy('year', 'tri')->
        get();

        $trimester_combinations = [];
        foreach ($trimester_number as $item) {
            $trimester_combinations[] = [$item->year, $item->tri];
        }

        $currentTrimesterLength = count($trimester_combinations);
        $currentTrimester = $trimester_combinations[$currentTrimesterLength - 1];
        // dd($trimester_combinations);


        //add 5 more years to the total list of years based on the highest year in the database
        $years = DB::table('offerings')->select('year')->distinct()->get();
        $total_years = $years->pluck('year')->toArray();
        $highestYear = max($total_years);
        for ($i = 1; $i <= 5; $i++) {
            $total_years[] = $highestYear + $i;
        }

        $year = $request->input('year', date('Y'));
        $trimester = $request->input('trimester', 1);

            // Find the index of the current trimester in the array
        $current_index = array_search([$year, $trimester], $trimester_combinations);

        // Calculate the index of the previous and next trimesters
        $prev_index = max(0, $current_index - 1);
        $next_index = min(count($trimester_combinations) - 1, $current_index + 1);

        // Get the previous and next trimesters
        $prev_trimester = $trimester_combinations[$prev_index];
        $next_trimester = $trimester_combinations[$next_index];

        $offerings = Offering::all()
            ->where('year', $currentTrimester[0])
            ->where('trimester', $currentTrimester[1]);

        $offerings = Offering::where('year', $year)->where('trimester', $trimester)->get();

        // list of all courses, unique codes
        $courses = Course::all()->unique('code');

        // list of academics
        $academics = Academic::all()->unique('id');


        return view('trimester.create', compact('threshold_trimester', 'academics', 'trimester_number', 'offerings', 'prev_trimester', 'next_trimester', 'courses', 'total_years'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $year, $trimester)

    {
        $setting = Setting::latest()->first();
        $threshold_trimester = $setting ? $setting->threshold_trimester : null;
        $year = $request->input('year', $year);
        $trimester = $request->input('trimester', $trimester);

        $trimester_number = DB::table('offerings')
            ->select('year', 'trimester AS tri')
            ->groupBy('year', 'tri')
            ->get();

        $trimester_combinations = [];
        foreach ($trimester_number as $item) {
            $trimester_combinations[] = [$item->year, $item->tri];
        }

        $current_index = array_search([$year, $trimester], $trimester_combinations);
        $prev_index = max(0, $current_index - 1);
        $next_index = min(count($trimester_combinations) - 1, $current_index + 1);

        $prev_trimester = $trimester_combinations[$prev_index];
        $next_trimester = $trimester_combinations[$next_index];


        $classes = ClassSchedule::whereHas('offering', function ($query) use ($year, $trimester) {
            $query->where('year', $year);
            $query->where('trimester', $trimester);
        })->get();

        // offerings offered in the current trimester
        $offerings = Offering::whereHas('course')->where('year', $year)->where('trimester', $trimester)->get();
        $academics = Academic::all()->unique('id')->sortBy('firstname');
        $campuses = ['GC', 'NA', 'OL'];
        $class_types = ['Lecture', 'Workshop'];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        return view('trimester.edit', compact('threshold_trimester',  'days', 'class_types', 'campuses', 'year', 'trimester', 'classes', 'offerings', 'academics', 'trimester_number', 'prev_trimester', 'next_trimester'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        //
        // delete offerings that match the year and trimester

        $year = $request->input('year');
        $trimester = $request->input('trimester');

        // dd($year, $trimester);
        Offering::where('year', $year)->where('trimester', $trimester)->delete();

        // get all trimester the year + trimester

        $trimester_number = DB::table('offerings')->
        select('year', 'trimester AS tri')->
        groupBy('year', 'tri')->
        get();

        $trimester_combinations = [];
        foreach ($trimester_number as $item) {
            $trimester_combinations[] = [$item->year, $item->tri];
        }

        $currentTrimesterLength = count($trimester_combinations);
        $currentTrimester = $trimester_combinations[$currentTrimesterLength - 1];
        // dd($trimester_combinations);
        $year = $currentTrimester[0];
        $trimester = $currentTrimester[1];


        return redirect()->route('trimester.index', ['year' => $year, 'trimester' => $trimester]);

    }

    /**
     * Copy Trimester
     */
    public function copy(Request $request)
    {
        // Validate the incoming request
        // dd($request->all());
        $request->validate([
            'current_year' => 'required|integer',
            'current_trimester' => 'required|integer',
            'copy_year' => 'required|integer',
            'copy_trimester' => 'required|integer',
        ]);

        // Extract data from the request
        $currentYear = $request->input('current_year');
        $currentTrimester = $request->input('current_trimester');
        $copyYear = $request->input('copy_year');
        $copyTrimester = $request->input('copy_trimester');

        // check if copyear and copytrimester already exist
        $trimester = Offering::where('year', $copyYear)->where('trimester', $copyTrimester)->get();
        if ($trimester->count() > 0) {
            // return redirect()->route('trimester.index')->with('error', 'The trimester already exists');
            return redirect()->back()->with('error', 'The trimester already exists');

        }

        // Get offerings for the current trimester
        $offerings = Offering::where('year', $currentYear)
            ->where('trimester', $currentTrimester)
            ->get();

        // dd($offerings);

        // Copy offerings to the new trimester
        foreach ($offerings as $offering) {
            $newOffering = $offering->replicate();
            $newOffering->year = $copyYear;
            $newOffering->trimester = $copyTrimester;
            $newOffering->save();
        }

        // Redirect to the edit page of the new trimester
        return redirect()->route('trimester.edit', ['year' => $copyYear, 'trimester' => $copyTrimester]);
    }

    /**
     * Save the edited offerings.
     */
    public function save(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'offering_id.*' => 'nullable|exists:offerings,id',
            'class_type.*' => 'nullable|string',
            'campus.*' => 'nullable|string',
        ]);

        $classScheduleIDs = $request->input('class_id', []);

        foreach ($classScheduleIDs as $index => $id) {
            // find the index number of the class schedule
            $rowNo = array_search($id, $classScheduleIDs);

            $class = classSchedule::find($id);
            $offering_id = $request->input('offering_id')[$rowNo];
            // dd($offering_id);
            $offering = Offering::find($offering_id);

            if ($class) {
                $class->academic_id = $request->input('academic_id')[$rowNo];
                $class->class_type = $request->input('class_type')[$rowNo];
                $class->start_time = $request->input('start_time')[$rowNo];
                $class->end_time = $request->input('end_time')[$rowNo];
                $class->class_day = $request->input('class_day')[$rowNo];

                try {
                    // dd($offering);
                    $class->save();
                } catch (\Exception $e) {
                    // dd($request->all());
                    return redirect()->back()->with('error', 'An error occurred while saving the offering and class.');
                }
                // dd($offering);

            }
        }

        if ($request->has('delete')) {
            ClassSchedule::destroy($request->input('save_row'));
        }

        else if ($request->input('new_offering_id')) {
            foreach ($request->input('new_offering_id') as $i => $offering_id) {
                $offering = Offering::
                where('id', $offering_id)->first();

                // create new class
                $class = new ClassSchedule();
                $class->offering_id = $offering->id;
                $class->academic_id = $request->new_academic_id[$i] ?? null;
                $class->class_type = $request->new_class_type[$i];
                $class->start_time = $request->new_start_time[$i];
                $class->end_time = $request->new_end_time[$i];
                $class->class_day = $request->new_class_day[$i];
                $class->save();
            }
        }

        $year = $request->year;
        $trimester = $request->trimester;

        return redirect()->route('trimester.edit', ['year' => $year, 'trimester' => $trimester])->with('success', 'Trimester offerings updated successfully!');
    }

    /**
     * Import trimesters from a file.
     */
    public function import(Request $request)
    {
        try {
            $import = new TrimestersImport();
            Excel::import($import, $request->file('file'));
            return back()->with('success', 'Trimesters imported successfully!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return redirect()->back()->withFailures($failures);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Export trimesters to a file.
     */
    public function export(string $year, string $trimester)
    {
        return Excel::download(new TrimestersExport($trimester, $year), 'trimesters.xlsx');
    }
}
