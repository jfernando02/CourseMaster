<?php

namespace App\Http\Controllers;


use App\Http\Controllers\ReportsController;
use Illuminate\Http\Request;
use App\Models\Academic;
use App\Models\Offering;
use App\Models\Course;
use App\Models\ClassSchedule;
use App\Models\Setting;


use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AcademicsImport;
use App\Exports\AcademicsExport;
use App\Exports\AcademicWorkloadExport;

class AcademicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the academics.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $academics = Academic::with('course')->get()->sortBy('firstname');
        $offerings = Offering::with('course')->get();
        $courses = Course::all();
        $classes = ClassSchedule::all();
        $offering_trimester = Offering::select('year', 'trimester')->distinct()->get();
        $settings = Setting::latest()->first();

        $displayAssignedOfferings = session('displayAssignedOfferings', false);
        // $unassigned_academics = [];

        return view('academic.index', compact('classes', 'academics', 'offerings', 'offering_trimester', 'settings'));
    }

    /**
     */
    public function create()
    {
        return view('academic.add_academic');
    }

    /**
     * Check if the offering with the same academic exists
     */
    function checkExist($firstname, $lastname){
        $academics = Academic::where('firstname', $firstname)
                            ->where('lastname', $lastname)->get();
        if ($academics->isEmpty()) return false;
        else return true;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|max:255',
//             'teaching_load' => 'numeric'
        ]);

        //Check if the convenor exists before adding
        if ($this->checkExist($request->firstname, $request->lastname))
            return back()->withInput()->with('error', 'Academic not added! This academic already exists!');;
        $academic = new Academic();
        $academic->firstname = $request->firstname;
        $academic->lastname = $request->lastname;
        $academic->email = $request->email;
        $academic->teaching_load = $request->teaching_load;
        $academic->yearly_teaching_load = $request->yearly_teaching_load;
        $academic->area = $request->area;
        $academic->note = $request->note;
        $academic->save();
        return redirect("academic");
    }

    /**
     * Report for Academics per campus.
     */
    public function reportByCampus(string $academicID, string $campus)
    {
        $offerings = Offering::where('academic_id', $academicID)
            ->where('campus', $campus)
            ->get();
        return $offerings;
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $academic = Academic::findOrFail($id);
        $offerings = $academic->offerings;
        // $teachingHours = $this->teachingHours($academic->id); // Call the teachingHours function
        $classes = ClassSchedule::where('academic_id', $academic->id)->get();

        $classOfferingIDs = [];
        foreach ($classes as $classSchedule){
            array_push($classOfferingIDs, $classSchedule->offering_id);
        }
        $classOfferings = Offering::whereIn('id', $classOfferingIDs)
        ->get(['year', 'trimester'])
        ->unique(function ($item) {
            return $item['year'] . '-' . $item['trimester'];
        });

        // put teaching hours of each trimester in an array using year trimester of classOfferings
        $teachingHours = [];
        foreach ($classOfferings as $classOffering) {
            $year = $classOffering->year;
            $trimester = $classOffering->trimester;
            $teachingHours[$year . '-' . $trimester] = [
                'year' => $year,
                'trimester' => $trimester,
                'hours' => $academic->teachingHours($academic->id, $year, $trimester)
            ];
        }

        $offerings_arr = [];
        foreach ($offerings as $offering){
            $year = strval($offering->year);
            if (array_key_exists($year, $offerings_arr)) {
                array_push($offerings_arr[$year], $offering);
            } else {
                $offerings_arr[$year] = array($offering);
            }
        }


        $offeringGC = $this->reportByCampus($id, "GC");
        $offeringNA = $this->reportByCampus($id, "NA");
        $offeringOL = $this->reportByCampus($id, "OL");

        return view('academic.show', compact('teachingHours', 'classes', 'academic', 'offeringGC', 'offeringNA', 'offeringOL','classes'))->with('years_offerings', array_reverse($offerings_arr));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {

        // dd('edit');
        $academics = Academic::with('course')->get();
        $offerings = Offering::with('course')->get();
        $courses = Course::all();

        // $academic = Academic::findOrFail($id);
        // return view('academic.edit_form')->with('academic', $academic);
        return view('academic.edit_form', compact('academics', 'offerings', 'courses'));
    }

    public function edit_bulk(string $id)
    {

        // dd('edit');
        $academics = Academic::with('course')->get();
        $offerings = Offering::with('course')->get();
        $courses = Course::all();
        $campuses = Setting::latest()->first()->campuses;
        $campuses = json_decode($campuses, true);
        // dd($campuses);

        // $academic = Academic::findOrFail($id);
        // return view('academic.edit_form')->with('academic', $academic);
        return view('academic.edit_form', compact('campuses', 'academics', 'offerings', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
//            'teaching_load' => 'numeric'
        ]);

        $academic = Academic::findOrFail($id);
        $academic->firstname = $request->firstname;
        $academic->lastname = $request->lastname;
        $academic->teaching_load = $request->teaching_load;
        $academic->yearly_teaching_load = $request->yearly_teaching_load;
        $academic->area = $request->area;
        $academic->note = $request->note;
        $academic->save();
        return redirect("academic/$academic->id");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $academic = Academic::findOrFail($id);
        $academic->delete();
        return redirect("academic");
    }

    public function toggleOfferings(Request $request)
{
        // // Toggle the state based on the button's value
        // $displayAssignedOfferings = $request->input('toggle') == '1' ? true : false;

        // // Store the new state in the session
        // session(['displayAssignedOfferings' => $displayAssignedOfferings]);

        // // Redirect back to the index or wherever the list is displayed

        $selectedTrimester = $request->input('trimester');

        list($year, $trimester) = explode('-', $selectedTrimester);

        $academics = Academic::orderBy('lastname')->get();
        $offerings = Offering::where('year', $year)
                    ->where('trimester', $trimester)
                    ->get();
        $academics = $academics->filter(function ($academic) use ($offerings) {
            return $offerings->contains('academic_id', $academic->id);
        });


        $offering_trimester = Offering::select('year', 'trimester')->distinct()->get();

        // create $unassigned_academics
        $unassigned_academics = Academic::orderBy('lastname')->get();
        $unassigned_academics = $unassigned_academics->filter(function ($academic) use ($offerings) {
            return !$offerings->contains('academic_id', $academic->id);
        });


        return view('academic.index')
            ->with('academics', $academics)
            ->with('offerings', $offerings)
            ->with('offering_trimester', $offering_trimester)
            ->with('selectedTrimester', $selectedTrimester)
            ->with('unassigned_academics', $unassigned_academics);

    }

    public function saveAcademics(Request $request)
    {
        $ids = $request->input('id');  // Getting IDs to find each academic
        $firstnames = $request->input('firstname');
        $lastnames = $request->input('lastname');
        $emails=$request->input('email');
        $teaching_loads = $request->input('teaching_load');
        $yearly_teaching_loads = $request->input('yearly_teaching_load');
        $areas = $request->input('area');
        $home_campuses = $request->input('home_campus');
        $notes = $request->input('note');
        // dd($ids);
        if ($request->has('delete')) {
            // Perform deletion operation on selected classes
            Academic::destroy($request->input('save_row'));
        }

        foreach ($ids as $index => $id) {
            $academic = Academic::find($id);
            if ($academic) {
                $academic->firstname = $firstnames[$index];
                $academic->lastname = $lastnames[$index];
                $academic->email=$emails[$index];
                $academic->teaching_load = $teaching_loads[$index];
                $academic->yearly_teaching_load = $yearly_teaching_loads[$index];
                $academic->area = $areas[$index];
                $academic->home_campus = $home_campuses[$index];
                $academic->note = $notes[$index];
                $academic->save();
            }
        }

        return redirect()->route('academic.index')->with('success', 'Academics updated successfully!');
    }

    public function deleteClassSchedule($id)
    {
        $classSchedule = ClassSchedule::findOrFail($id);
        $academicID = $classSchedule->academic_id;
        $classSchedule->delete();

        return redirect("academic/$academicID")->with('success', 'Class schedule deleted successfully');
    }

    public function import(Request $request)
    {
        try {
            $import = new AcademicsImport;
            Excel::import($import, $request->file('file'));
            return back()->with('success', 'Academics Batch updated successfully!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return back()->withFailures($failures);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }

    // export excel file with details of all academics
    public function export(string $id)
    {
        return Excel::download(new AcademicsExport, 'academics.xlsx');
    }

    public function exportWorkload(string $id)
    {
        return Excel::download(new AcademicWorkloadExport, 'academicworkload.xlsx');
    }
}
