@extends('layouts.master')

@section('title')
  Offerings
@endsection

@section('content')
<h1>Edit Offerings</h1>
<a class="btn btn-outline-primary" href="{{ url('offering/create') }}"><i class="fa-regular fa-plus"></i> Add a new offering</a>
<form method="POST" action="{{ route('offering.saveBulk') }}">
  @csrf
<table class="table table-striped" id="offeringsTable">
  <thead>
    <th>
      <input type="text" class="form-control filter-input" placeholder="Search ID" data-column="0">
    </th>
    <th>
      <input type="text" class="form-control filter-input" placeholder="Search Code" data-column="1">
    </th>
    <th>
      <input type="text" class="form-control filter-input" placeholder="Search Course" data-column="2">
    </th>
    <th>
      <input type="text" class="form-control filter-input" placeholder="Search Year" data-column="3">
    </th>
    <th>
      <input type="text" class="form-control filter-input" placeholder="Search Trimester" data-column="4">
    </th>
    <th>
      <input type="text" class="form-control filter-input" placeholder="Search Campus" data-column="5">
    </th>
    <th>
      <input type="text" class="form-control filter-input" placeholder="Search Convenor" data-column="6">
    </th>
    <th>
      <input type="text" class="form-control filter-input" placeholder="Search Notes" data-column="7">
    </th>
    <tr>
      <th>ID</th>
      <th>Code</th>
      <th>Course</th>
      <th>Year</th>
      <th>Trimester</th>
      <th>Campus</th>
      <th>Convenor</th>
      <th>Notes</th>
        <th>Select</th>

    </tr>
  </thead>
  <tbody>
    @foreach($offerings as $offering)
    <tr>
      <td><input class="form-control" type="text" name="id[]"   value="{{$offering->id}}"></td>
      <td><input class="form-control" type="text" name="code[]"   value="{{$offering->course->code}}"></td>
      <td><input class="form-control" type="text" name="name[]"   value="{{$offering->course->name}}"></td>
      <td><input class="form-control" type="text" name="year[]"   value="{{$offering->year}}"></td>
      <td><input class="form-control" type="text" name="trimester[]" value="{{$offering->trimester}}"></td>
      {{-- <td><input class="form-control" type="text" name="campus" value="{{$offering->campus}}"></td> --}}
      <td>
        <select class="form-control" name="campus[]">
        @foreach($campuses as $campus)
          <option value="{{$campus}}" {{$offering->campus == $campus ? 'selected' : ''}}>{{$campus}}</option>
        @endforeach
        </select>
      </td>
      <td>
        {{-- @if(isset($offering->convenor))
        <a href='{{url("academic/{$offering->convenor->id}")}}'>
        {{$offering->convenor->firstname}} {{$offering->convenor->lastname}}</a>
        @else Unassigned
        @endif --}}
        <select class="selectpicker form-control" name="academic_id[]">
          {{-- <option
          title="ddd"
          >Select Lecturer</option> --}}
          @foreach ($academics as $academic)

              <option


              class="dropdown-item custom-tooltip"
              value="{{ $academic->id }}" @if ($academic->id == $offering->academic_id) selected @endif
              >
             {{ $academic->firstname }} {{ $academic->lastname }} ({{$academic->home_campus}})
              </option>
          @endforeach
      </select>
      </td>
      </td>
      <td>
        <input class="form-control" type="text" name="note[]" value="{{$offering->note}}">
      </td>
        <td><div class="form-check">
                <input class="btn btn-outline-success" type="checkbox" name="save_row[]" value="{{ $offering->id }}">
            </div></td>
    </tr>
    @endforeach
  </tbody>
</table>
<button type="submit" class="btn btn-primary">Save</button>


<script>

document.addEventListener('DOMContentLoaded', function() {
  const filters = document.querySelectorAll('.filter-input');

  filters.forEach(filter => {
    filter.addEventListener('keyup', function() {
      const columnIndex = parseInt(this.getAttribute('data-column'));
      const query = this.value.toLowerCase();
      const rows = document.querySelector("#offeringsTable tbody").rows;

      for (let row of rows) {
        let showRow = true;

        filters.forEach(filter => {
          if (filter.value !== '') {
            const colIndex = parseInt(filter.getAttribute('data-column'));
            const cell = row.cells[colIndex];
            const inputValue = cell.querySelector('input')?.value.toLowerCase() || '';

            if (!inputValue.includes(filter.value.toLowerCase())) {
              showRow = false;
            }
          }
        });

        row.style.display = showRow ? '' : 'none';
      }
    });
  });
});

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
</script>
@endsection
