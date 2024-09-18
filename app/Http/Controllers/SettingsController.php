<?php

namespace App\Http\Controllers;
use App\Models\Setting;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = Setting::latest()->first();
        // dd($setting);
        $department = $setting ? $setting->department : null;

        $threshold_year = $setting ? $setting->threshold_year : null;
        $threshold_trimester = $setting ? $setting->threshold_trimester : null;
        $underwork_threshold_year = $setting ? $setting->underwork_threshold_year : null;
        $underwork_threshold_trimester = $setting ? $setting->underwork_threshold_trimester : null;
        $current_year = $setting ? $setting->current_year : null;
        $current_trimester = $setting ? $setting->current_trimester : null;
        $campuses = $setting ? json_decode($setting->campuses) : null;

        return view('settings.index', compact('campuses', 'department', 'threshold_year', 'threshold_trimester', 'underwork_threshold_year', 'underwork_threshold_trimester', 'current_year', 'current_trimester'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'department' => 'required|string',
        ]);

        $setting = new Setting();
        $setting->department = $request->department;
        $setting->threshold_year = $request->threshold_year;
        $setting->threshold_trimester = $request->threshold_trimester;
        $setting->underwork_threshold_year = $request->underwork_threshold_year;
        $setting->underwork_threshold_trimester = $request->underwork_threshold_trimester;
        $setting->current_year = $request->current_year;
        $setting->current_trimester = $request->current_trimester;
        $setting->campuses = json_encode($request->campuses);


        $setting->save();
        // return with succcess
        return redirect('settings')->with('success', 'Department settings saved successfully');

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
    public function edit(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
