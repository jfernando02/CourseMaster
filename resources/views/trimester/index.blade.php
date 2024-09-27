@extends('layouts.master')

@section('title')
    Classes
@endsection

@section('content')

    {{-- display error --}}
    @if(session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif
    {{-- display success --}}
    @if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
    @if (session('failures'))
    <div class="alert alert-danger">
        <ul>
            @foreach (session('failures') as $failure)
                <li>Row {{ $failure->row() }}: {{ $failure->errors()[0] }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <h1>Trimesters</h1>
    {{-- display currentTrimester --}}
    <h2>{{ $currentTrimester[0] }} {{ $currentTrimester[1] }}</h2>
    {{-- display the previous and next trimester --}}

    <div class="row mt-3">
        <div class="col-4">
            <form action="{{ route('trimester.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <div class="input-group">
                        <input type="file" id = "fileInput" name="file" class="form-control">
                        <button class="btn btn-outline-primary" id="uploadButton" disabled><i class="fas fa-upload"></i>Upload Excel File</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-4">
            <a class="btn btn-outline-primary" href="{{ url('trimester/export/' . $currentTrimester[0] . '/' . $currentTrimester[1]) }}"><i class="fas fa-download"></i>Download Excel File</a>
        </div>
    </div>


    <div class="d-flex justify-content-between">
        <a class="btn btn-outline-primary"
            href="{{ route('trimester.index', [
                'year' => $prev_trimester[0],
                'trimester' => $prev_trimester[1],
                'currentTrimester' => [$prev_trimester[0], $prev_trimester[1]],
            ]) }}">
            <i class="fa-solid fa-angle-left"></i> Previous Trimester
        </a>



        <form action="{{ route('trimester.index') }}" id="selectTrimester" method="GET">
            <input type="hidden" id="year" name="year" value="" />
            <input type="hidden" id="trimester" name="trimester" value="" />
            <div class="dropdown">
                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Select Trimester
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    @foreach ($trimester_number as $trimester)
                        <li>
                            <button class="dropdown-item"
                                    type="button"
                                    onclick="submitSelectTrimester('{{ $trimester->year }}', '{{ $trimester->tri }}')">
                                {{ $trimester->year }} {{ $trimester->tri }}
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </form>
        <a class="btn btn-outline-primary" href="{{ route('trimester.create') }}"><i class="fa-regular fa-plus"></i> Create Trimester</a>
        <a class="btn btn-outline-primary" href="{{ route('trimester.edit', ['year' => $currentTrimester[0], 'trimester' => $currentTrimester[1]]) }}"><i class="fa-regular fa-pen-to-square"></i> Edit Trimester</a>
        {{-- Form for copying trimester --}}
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#copyTrimesterModal">
            <i class="fa-regular fa-copy"></i> Copy Trimester
        </button>
        <div class="modal fade" id="copyTrimesterModal" tabindex="-1" aria-labelledby="copyTrimesterModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="copyTrimesterModalLabel">Copy Trimester</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('trimester.copy') }}" method="POST">
                            @csrf
                            <input type="hidden" name="current_year" value="{{ $currentTrimester[0] }}">
                            <input type="hidden" name="current_trimester" value="{{ $currentTrimester[1] }}">
                            <div class="row">
                                <div class="col">
                                    <label for="copy_year" class="form-label">Copy to Year</label>
                                    <input type="text" class="form-control" id="copy_year" name="copy_year">
                                </div>
                                <div class="col">
                                    <label for="copy_trimester" class="form-label">Copy to Trimester</label>
                                    <input type="text" class="form-control" id="copy_trimester" name="copy_trimester">
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-outline-primary">Copy Trimester</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- <a class="btn btn-outline-primary"
        href="{{ route('trimester.index', ['year' => $next_trimester[0], 'trimester' => $next_trimester[1]]) }}">
        Next Trimester <i class="fa-solid fa-angle-right"></i>
    </a> --}}
        <a class="btn btn-outline-primary"
            href="{{ route('trimester.index', [
                'year' => $next_trimester[0],
                'trimester' => $next_trimester[1],
                'currentTrimester' => [$next_trimester[0], $next_trimester[1]],
            ]) }}">
            Next Trimester <i class="fa-solid fa-angle-right"></i>
        </a>

    </div>

    {{-- create a table of trimesters showing the offering details based on the offerings table but based on the current selected trimester --}}
    <table class="table table-hover" id="offeringsTable">
        <thead>
            <tr>
                <th>Course</th>
                <th>Lecturers</th>
                <th>Class Type</th>
                <th>Campus</th>
                <th>Time Start</th>
                <th>Time End</th>
                <th>Day</th>
            </tr>
            <tr>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search courses" data-column="0">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search lecturers" data-column="1">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search class type" data-column="2">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search campus" data-column="3">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search start time" data-column="4">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search end time" data-column="5">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search day" data-column="6">
                </td>
            </tr>
        </thead>
        <tbody>
            @foreach ($classSchedules as $classSchedule)
                <tr>
                    <td>
                                @if ($course = $classSchedule->offering->course)
                                {{ $course->code }} {{ $course->name }}
                                 @endif

                    </td>
                    <td>

                                    @if ($academic = $classSchedule->academic->first())

                                    {{ $academic->firstname }} {{ $academic->lastname }}
                                    @endif
                    </td>
                    <td>


                                @if ($class_type = $classSchedule->class_type)

                                {{ $class_type }}
                                @endif

                    </td>
                    <td>

                                    @if ($campus = $classSchedule->offering->campus)
                                    {{ $campus }}
                                    @endif


                    </td>
                    <td>
                        {{ $classSchedule->start_time }}
                    </td>
                    <td>
                        {{ $classSchedule->end_time }}
                    </td>
                    <td>

                        @if ($day =$classSchedule->class_day)
                            {{ $day }}
                        @endif


                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>


    </form>
    <form action="{{ route('trimester.delete', ['year' => $currentTrimester[0], 'trimester' => $currentTrimester[1]]) }}"
        method="POST">
        @csrf
        <button type="submit" class="btn btn-outline-danger"><i class="fa-regular fa-trash-can"></i>  Delete</button>
    </form>


<script src="{{ asset('js/table-filter.js') }}"></script>
    <script>
        function submitSelectTrimester(year, tri) {
            document.getElementById('year').value = year;
            document.getElementById('trimester').value = tri;
            document.getElementById('selectTrimester').submit();
        }
    </script>
@endsection
