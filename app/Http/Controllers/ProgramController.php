<?php

namespace App\Http\Controllers;
use App\Models\Program;

use Illuminate\Http\Request;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programs = Program::all();
        return view('program.index')->with('programs', $programs);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('program.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:10',
            'fullname' => 'max:255',
            'code' => 'max:10'
        ]);
    
       // To do: check if the convenor exists before adding
        $program = new Program();
        $program->name = $request->name;
        $program->fullname = $request->fullname;
        $program->code = $request->code;
        $program->note = $request->note;
        $program->save();
        return redirect("program");
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
