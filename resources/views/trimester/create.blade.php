@extends('layouts.master')

@section('title')
    Trimesters
@endsection

@section('content')
<div class="row">
    <div class="col-2">
        <table class="table table-font-size">
            <tr>
                <th>List of Academics</th>
            </tr>
            @foreach ($academics as $academic)
                <tr>
                    <td data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-custom-class="custom-tooltip" data-bs-html="true" data-bs-title="Previous Teaching Load: {{$academic->teaching_load}} <br>Notes: {{$academic->note}}">
                        {{ $academic->firstname }} {{ $academic->lastname }}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="col-10">
        <h1>Create Trimester Template</h1>
        <div class='row'>
            <div class="d-flex justify-content-between">
                <a class="btn btn-outline-primary"
                    href="{{ route('trimester.index', ['year' => $prev_trimester[0], 'trimester' => $prev_trimester[1]]) }}">
                    <i class="fa-solid fa-chevron-left"></i> Previous Trimester
                </a>
                <a class="btn btn-outline-primary"
                    href="{{ route('trimester.index', ['year' => $next_trimester[0], 'trimester' => $next_trimester[1]]) }}">
                    Next Trimester <i class="fa-solid fa-chevron-right"></i>
                </a>
    
            </div>
            

            <div class="col-6 row">
                <form action="{{ url('trimester') }}" method="GET">
                <div class="col-6 input-group">
                    <label class="col-3 input-group-text" name="year">Select Year</label>
                    <select class="col-9 form-select">
                    <option value="">Select Year</option>
                    @foreach ($total_years as $loop_year)
                        <option value="{{ $loop_year }}">
                        {{ $loop_year }}
                        </option>
                    @endforeach
                    </select>
                </div>
    
                <div class="col-6 input-group">
                    <label class="col-3 input-group-text" name="year">Select Trimester</label>
                    <select class="col-9 form-select" name="trimester">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    </select>
                </div>
            </div>
    
        </div>
        </form>
    
        {{-- create a table of trimesters showing the offering details based on the offerings table but based on the current selected trimester --}}
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Course</th>
                    <th>Lecturers</th>
                    <th>Course Delivery</th>
                    <th>Class Type</th>
                </tr>
            </thead>
            <tbody id="trimester-table-body">
                    <tr>
                            <td>
                                <div class="form-group">
                                    <select class="form-control" name="course_id">
                                        <option>Select Course</option>
                                        @foreach ($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->code }} {{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select class="selectpicker" name="lecturer_id">
                                        <option 
                                        {{-- title="ddd" --}}
                                        >Select Lecturer</option>
                                        @foreach ($academics as $academic)
                                        @php
                                        $load = $academic->teachingHoursperSem($academic->id, 2022, 1); 
                                        $ratio = min(($load / 100), 1) * 100; 

                                        @endphp
                                            <option data-ratio="{{ $ratio }}" data-bs-toggle="tooltip" data-bs-placement="top"

                                            {{-- style="background: linear-gradient(to left, rgba(255, 0, 0, 0.5) {{ $ratio }}%, white {{ $ratio }}%);" --}}

                                            data-bs-custom-class="custom-tooltip" data-bs-html="true" data-bs-title="Previous Teaching Load: {{$academic->teaching_load}} <br>Notes: {{$academic->note}}" class="dropdown-item" value="{{ $academic->id }}" title="Load: {{$academic->teaching_load}} Notes: {{$academic->note}}">
                                           {{ $academic->firstname }} {{ $academic->lastname }}
                                            </option>
                                        @endforeach


                                    </select>
                                </div>
                            </td>
                            <td>

                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="course_delivery[]" value="Gold Coast" id="gold_coast">
                                        <label class="form-check-label" for="gold_coast">Gold Coast</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="course_delivery[]" value="Nathan" id="nathan">
                                        <label class="form-check-label" for="nathan">Nathan</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="course_delivery[]" value="Online" id="online">
                                        <label class="form-check-label" for="online">Online</label>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="class_type[]" value="Lecture" id="lecture">
                                        <label class="form-check-label" for="lecture">Lecture</label>
                                        <input class="form-control" type="number" name="lecture_count" min="0">
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="class_type[]" value="Workshop" id="workshop">
                                        <label class="form-check-label" for="workshop">Workshop</label>
                                        <input class="form-control" type="number" name="workshop_count" min="0">
                                    </div>
                                </div>
                            </td>
                        </td>
                    </tr>
            </tbody>
        </table>
        {{-- add new row button --}}
        <button class="btn btn-outline-primary" onclick="addNewRow()""><i class="fa-regular fa-plus"></i> Add New Row</button>
        {{-- save button --}}
        <button class="btn btn-outline-success" type="submit"><i class="fa-regular fa-floppy-disk"></i> Save</button>

        </form>
    
        <script>
            function addNewRow() {
                // Clone the first row of the table body
                var newRow = document.getElementById('trimester-table-body').rows[0].cloneNode(true);
    
                // Append the cloned row to the table body
                document.getElementById('trimester-table-body').appendChild(newRow);
            }
        </script>
    </div>    
</div>

@endsection
