@extends('layouts.master')

@section('title')
  Settings
@endsection



@section('content')
@if(session('success'))
    <div class="alert alert-success" role="alert">
        {{session('success')}}
    </div>
@endif

    <!-- show current departmentm -->
    @if (isset($department))
        <h1>Department: {{ $department }}</h1>
    @endif
    <!-- create an input to save the name of the department -->
    <div class="container mt-5">
        <h2>Manage Settings</h2>
        <form action="{{ url('settings') }}" method="post">
            @csrf
            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <input type="text" class="form-control" id="department" name="department" placeholder="Enter Department"
                    value="{{ $department }}">
            </div>

            <div class="mb-3">
                <label for="threshold_year" class="form-label">Overwork Teaching Load Threshold (Yearly) (e.g. 120% of given teacher yearly load)</label>
                <input type="number" class="form-control" id="threshold_year" name="threshold_year"
                    placeholder="Enter Overwork Yearly Teaching Load Threshold" value="{{ $threshold_year }}">
            </div>

            <div class="mb-3">
                <label for="threshold_trimester" class="form-label">Overwork Teaching Load Threshold (Trimester) (e.g. 120% of given teacher trimester load)</label>
                <input type="number" class="form-control" id="threshold_trimester" name="threshold_trimester"
                    placeholder="Enter Overwork Trimester Teaching Load Threshold" value="{{ $threshold_trimester }}">
            </div>

            <div class="mb-3">
                <label for="threshold_year" class="form-label">Underwork Teaching Load Threshold (Yearly) (e.g. 80% of given teacher yearly load)</label>
                <input type="number" class="form-control" id="underwork_threshold_year" name="underwork_threshold_year"
                       placeholder="Enter Yearly Underwork Teaching Load Threshold" value="{{ $underwork_threshold_year }}">
            </div>

            <div class="mb-3">
                <label for="threshold_trimester" class="form-label">Underwork Teaching Load Threshold (Trimester) (e.g. 80% of given teacher trimester load)</label>
                <input type="number" class="form-control" id="underwork_threshold_trimester" name="underwork_threshold_trimester"
                       placeholder="Enter Trimester Underwork Teaching Load Threshold" value="{{ $underwork_threshold_trimester }}">
            </div>

            <div class="mb-3">
                <label for="current_year" class="form-label">Current Year</label>
                <input type="number" class="form-control" id="current_year" name="current_year" value="{{ $current_year }}">
            </div>

            <div class="mb-3">
                <label for="current_trimester" class="form-label">Current Trimester</label>
                <input type="number" class="form-control" id="current_trimester" name="current_trimester"
                    value="{{ $current_trimester }}">
            </div>

            <div class="mb-3">
                <label for="campuses" class="form-label">Campuses</label>
                <div id="campuses" class="mb-2">
                    @foreach($campuses as $campus)
                    <div class="input-group mb-1">
                        <input type="text" class="form-control" name="campuses[]" value="{{ $campus }}">
                        <button type="button" class="btn btn-danger" onclick="removeCampus(this)">Remove</button>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-primary" onclick="addCampus()">Add Campus</button>
            </div>

            <button type="submit" class="btn btn-success">Submit</button>
        </form>
        <br>
        <br>
        <div class="form-group row">
            <label for="bd-theme">Choose Theme (Dark | Light | Auto)</label>
            <div class="bd-mode-toggle">
                <button class="btn py-2 dropdown-toggle d-flex align-items-center col-2 " id="bd-theme" type="button"
                    aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
                    <svg class="bi my-1 theme-icon-active" width="1em" height="1em">
                        <use href="#circle-half"></use>
                    </svg>
                    <span class="visually-hidden" id="bd-theme-text">Toggle theme</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="bd-theme-text">
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="light"
                            aria-pressed="false">
                            <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
                                <use href="#sun-fill">Light</use>
                            </svg>
                            Light
                            <svg class="bi ms-auto d-none" width="1em" height="1em">
                                <use href="#check2"></use>
                            </svg>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark"
                            aria-pressed="false">
                            <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
                                <use href="#moon-stars-fill"></use>
                            </svg>
                            Dark
                            <svg class="bi ms-auto d-none" width="1em" height="1em">
                                <use href="#check2"></use>
                            </svg>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="auto"
                            aria-pressed="true">
                            <svg class="bi me-2 opacity-50 theme-icon" width="1em" height="1em">
                                <use href="#circle-half"></use>
                            </svg>
                            Auto
                            <svg class="bi ms-auto d-none" width="1em" height="1em">
                                <use href="#check2"></use>
                            </svg>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>


    <script>
        function addCampus() {
            let container = document.getElementById('campuses');
            let inputGroup = document.createElement('div');
            inputGroup.classList.add('input-group', 'mb-1');
            inputGroup.innerHTML = `
                <input type="text" class="form-control" name="campuses[]">
                <button type="button" class="btn btn-danger" onclick="removeCampus(this)">Remove</button>
            `;
            container.appendChild(inputGroup);
        }

        function removeCampus(button) {
            button.closest('.input-group').remove();
        }

    </script>


@endsection

