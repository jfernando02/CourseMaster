@php use App\Models\Academic; @endphp
@extends('layouts.master')

@section('title')
    Edit Classes
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="row">

    <div >
        <h1>Edit Classes</h1>
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('trimester.save') }}" method="POST">

    <h2>{{ $year }} {{$trimester}}</h2>
        <div class='row'>
            <div class="d-flex justify-content-between">
                <a class="btn btn-outline-primary"

                    href="{{ route('trimester.edit', ['year' => $prev_trimester[0], 'trimester' => $prev_trimester[1]]) }}">
                    <i class="fa-solid fa-chevron-left"></i> Previous Trimester
                </a>

                <button id="toggleColumns" class="btn btn-outline-success">Toggle Time & Day Columns</button>

                <button class="btn btn-outline-success" type="submit"><i class="fa-regular fa-floppy-disk"></i> Save</button>
                @if (session('message'))
                    <script>
                        window.onload = function () {
                            alert("{{ session('message') }}");
                        }
                    </script>
                @endif
                <button class="btn btn-outline-danger" type="submit" name="delete" value="delete" onclick="return confirm('Are you sure you want to delete these classes?')"><i class="fa-regular fa-trash"></i> Delete Selected Classes</button>
                    <a class="btn btn-outline-primary"

                        href="{{ route('trimester.edit', ['year' => $next_trimester[0], 'trimester' => $next_trimester[1]]) }}">
                        <i class="fa-solid fa-chevron-right"></i> Next Trimester
                    </a>

            </div>

        </div>
        <br>


            <input type="hidden" name="year" value="{{ $year }}">
            <input type="hidden" name="trimester" value="{{ $trimester }}">
        @csrf
        <table class="table table-hover" id="offeringsTable">
            <thead>
                <tr class="sticky-header">
                    <th>
                        <input type="text" class="form-control filter-input" placeholder="Search offerings" data-column="0">
                    </th>
                    <th>
                        <input type="text" class="form-control filter-input" placeholder="Search lecturers" data-column="1">
                    </th>
                    <th>
                        <input type="text" class="form-control filter-input" placeholder="Search teaching load" data-column="2">
                    </th>
                    <th>
                        <input type="text" class="form-control filter-input" placeholder="Search teaching load (year)" data-column="3">
                    </th>
                    <th>
                        <input type="text" class="form-control filter-input" placeholder="Search class type" data-column="4">
                    </th>
                    <th>
                        <input type="text" class="form-control filter-input" placeholder="Search campus" data-column="5">
                    </th>
                    <th class='toggle-column'>
                        <input type="time" class="form-control filter-input" placeholder="Search start time" data-column="6">
                    </th>
                    <th class='toggle-column'>
                        <input type="time" class="form-control filter-input" placeholder="Search end time" data-column="7">
                    </th>
                    <th class='toggle-column'>
                        <input type="text" class="form-control filter-input" placeholder="Search day" data-column="8">
                    </th>
                    <th>
                        <input type="text" class="form-control filter-input" placeholder="Search notes" data-column="9">
                    </th>
                </tr>
                <tr>
                    {{-- <th>ID</th> --}}
                    <th>Offering</th>
                    <th>Lecturers</th>
                    <th>Teaching Load (Trimester)</th>
                    <th>Teaching Load (Year)</th>
                    <th>Class Type</th>
                    <th>Campus</th>
                    <th class='toggle-column'>Time Start</th>
                    <th class='toggle-column'>Time End</th>
                    <th class='toggle-column'>Day</th>
                    <th>Notes</th>
                    <th>Select</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($classes as $class)
                    <tr data-row-id="{{ $class->id }}">
                        <input type="hidden" name="class_id[]" id="selectedClassID" value="{{ $class->id }}">
                        <input type="hidden" name="offering_id[]" id="selectedOfferingID" value="{{ $class->offering_id }}">
                        <td>
                            {{optional($class->offering->course)->name}} ({{optional($class->offering->course)->code}})

                        </td>
                        <td>
                            <div class="form-group">
                                <select class="selectpicker form-control" name="academic_id[]">
                                    @foreach ($academics as $academic)
                                    @php
                                    $load = $academic->teachingHours($year ,$trimester);
                                    $ratio = min(($load / $threshold_trimester), 1) * 100;
                                    @endphp
                                        <option
                                        style="background: linear-gradient(to right, rgb(77, 181, 71) {{ $ratio }}%, white {{ $ratio }}%);"
                                        class="dropdown-item custom-tooltip"
                                        value="{{ $academic->id }}" @if ($academic->id == optional($class->academic()->first())->id) selected @endif
                                        >

                                       {{ $academic->firstname }} {{ $academic->lastname }} ({{$academic->home_campus}})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td>
                            @php
                                $academic = optional($class->academic()->first());
                                $load = $academic->teachingHours($year ,$trimester);
                                $workloadStatus = $academic->workloadStatus($load);
                            @endphp
                            @if($academic->exists)
                                @if($workloadStatus === 'OW')
                                    <span style="color: red;">{{ $load . ' hours '}}</span>
                                @elseif($workloadStatus === 'UW')
                                    <span style="color: blue;">{{ $load . ' hours '}}</span>
                                @else
                                    <span>{{ $load . ' hours '}}</span>
                                @endif
                            @endif
                        </td>
                        <td>
                            @php
                                $academic = optional($class->academic()->first());
                                $yearLoad = $academic->teachingHours($year ,0);
                                $yearWorkloadStatus = $academic->workloadStatus($yearLoad, "year");
                            @endphp
                            @if($academic->exists)
                                @if($yearWorkloadStatus === 'OW')
                                    <span style="color: red;">{{ $yearLoad . ' hours '}}</span>
                                @elseif($yearWorkloadStatus === 'UW')
                                    <span style="color: blue;">{{ $yearLoad . ' hours '}}</span>
                                @else
                                    <span>{{ $yearLoad . ' hours '}}</span>
                                @endif
                            @endif
                        </td>
                        <td>
                            <div class="form-group">
                                <select class="form-control" name="class_type[]">

                                @foreach ($class_types as $class_type)
                                    <option name="class_type[]" value="{{ $class_type }}"
                                    @if ($class_type == $class->class_type) selected @endif>
                                    {{ $class_type }}
                                @endforeach

                                </select>

                            </div>


                        </td>
                        <td>
                                {{$class->offering->campus}}

                        </td>
                        <td class='toggle-column'>
                            <div class="form-group ">
                                <input type="time" class="form-control" name="start_time[]" value="{{ $class->start_time }}">

                            </div>
                        </td>
                        <td class='toggle-column'>
                            <div class="form-group">
                                <input type="time" class="form-control" name="end_time[]" value="{{ $class->end_time }}">
                            </div>
                        </td>
                        <td class='toggle-column'>
                            <div class="form-group">
                                <select class="selectpicker" name="class_day[]">
                                    @foreach ($days as $day)
                                        <option value="{{ $day }}" @if ($day == $class->class_day) selected @endif>
                                            {{ $day }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        {{-- notes input --}}
                        <td>
                            <div class="form-group
                            ">
                                <input type="text" class="form-control" name="notes[]" value="{{ $class->note }}">
                            </div>
                        </td>
                        {{-- save button --}}
                        <td>

                            <div class="form-check">
                                <input class="btn btn-outline-success" type="checkbox" name="save_row[]" value="{{ $class->id }}">
                            </div>
                        </td>


                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="button" class="btn btn-outline-primary" onclick="addNewRow()"><i class="fa-regular fa-plus"></i> Add New Row</button>



    </form>
    </div>



</div>

<script>

function addNewRow() {
    const table = document.getElementById('offeringsTable').getElementsByTagName('tbody')[0];
    const newRow = table.insertRow(table.rows.length);
    const timeDayVisible = document.querySelector('.toggle-column').style.display !== 'none';

    let timeDayCells = `
        <td>
            <div class="form-group">
                <input type="time" class="form-control" name="new_start_time[]">
            </div>
        </td>
        <td>
            <div class="form-group">
                <input type="time" class="form-control" name="new_end_time[]">
            </div>
        </td>
        <td>
            <div class="form-group">
                <select class="form-control" name="new_class_day[]">
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                </select>
            </div>
        </td>
    `;

    newRow.innerHTML = `
    <tr>
        <input type="hidden" name="new_class_id[]" id="selectedClassID" value="new">
            <td>
                <select class="selectpicker" name="new_offering_id[]">
                @foreach ($offerings as $offering)
                    <option value="{{ $offering->id }}">{{ $offering->course->name}} ({{ $offering->course->code}}) at {{ $offering->campus}}</option>
                @endforeach
                </select>
            </td>
            <td>
                <select class="selectpicker" name="new_academic_id[]">
                @foreach ($academics as $academic)
                    <option value="{{ $academic->id }}">{{ $academic->firstname}} {{ $academic->lastname}}</option>
                @endforeach
                </select>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                <select class="form-control" name="new_class_type[]">
                @foreach ($class_types as $class_type)
                    <option name="class_type[]" value="{{ $class_type }}"
                    @if (isset($class) && $class_type == $class->class_type) selected @endif>
                    {{ $class_type }}
                @endforeach
                </select>
            </td>
            <td>
            </td>
            ${timeDayVisible ? timeDayCells : ''}
                <td>
                        <div class="form-group">
                            <input type="text" class="form-control" name="new_notes[]" >
                        </div>
                    </td>
                <td>
                    <div class="form-check">
                        <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">x</button>
                    </div>
                </td>
        </tr>


    `;
    $(newRow).find('.selectpicker').selectpicker();

}

</script>


<script>

function removeRow(button) {
    var row = button.parentNode.parentNode.parentNode;
    row.parentNode.removeChild(row);
}

// for filtering

document.addEventListener('DOMContentLoaded', function() {
  const filters = document.querySelectorAll('.filter-input');

  filters.forEach(filter => {
    filter.addEventListener('input', function() {
      const rows = document.querySelector("#offeringsTable tbody").rows;
      const currentColumnIndex = parseInt(this.getAttribute('data-column'));
      const query = this.value.toLowerCase();

      for (let row of rows) {
        let showRow = true;

        filters.forEach(filter => {
          if (filter.value !== '') {
            const colIndex = parseInt(filter.getAttribute('data-column'));
            const cell = row.cells[colIndex];
            let textContent = '';

            // Get textContent depending on cell content
            if (cell.querySelector('input')) {
              textContent = cell.querySelector('input').value.toLowerCase();
            } else if (cell.querySelector('select')) {
              const select = cell.querySelector('select');
              textContent = select.options[select.selectedIndex].text.toLowerCase();
            } else {
              textContent = cell.textContent.toLowerCase();
            }

            if (!textContent.includes(filter.value.toLowerCase())) {
              showRow = false; // Hide if any filter doesn't match
            }
          }
        });

        row.style.display = showRow ? '' : 'none';
      }
    });
  });
});

// toggle column
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('toggleColumns');
    toggleBtn.addEventListener('click', function() {
        event.preventDefault();
        // Select all elements with the class 'toggle-column' and toggle their visibility
        document.querySelectorAll('.toggle-column').forEach(column => {
            column.style.display = column.style.display === 'none' ? '' : 'none';
        });
    });
});

// highlight cell with modified data
document.addEventListener('DOMContentLoaded', function() {
        const formElements = document.querySelectorAll('input, select, textarea');
        formElements.forEach(element => {
            element.addEventListener('change', function() {
                let parentTd = this.closest('td');
                if (parentTd) {
                    parentTd.classList.add('modified');
                }
            });
        });
    });

</script>

@endsection
