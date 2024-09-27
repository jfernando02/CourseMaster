@extends('layouts.master')

@section('title')
  Offerings
@endsection

@section('content')
<h1>Edit Offerings</h1>

<form method="POST" action="{{ route('offering.saveBulk') }}">
  @csrf
    <div class='row'>
        <div class="d-flex justify-content-between">

            <a class="btn btn-outline-primary" href="{{ url('offering/create') }}"><i class="fa-regular fa-plus"></i> Add a new offering</a>

    <button class="btn btn-outline-danger" type="submit" name="delete" value="delete" onclick="return confirm('Are you sure you want to delete these offerings?')">
        <i class="fa-regular fa-trash"></i> Delete Selected Offerings
    </button>

            <button type="submit" class="btn btn-primary">Save</button>
            @if (session('message'))
                <script>
                    window.onload = function () {
                        alert("{{ session('message') }}");
                    }
                </script>
            @endif
        </div>
    </div>
<table class="table table-striped" id="offeringsTable">
  <thead>
    <th>
      <input type="text" class="form-control filter-input" placeholder="Search Code" data-column="0">
    </th>
    <th>
      <input type="text" class="form-control filter-input" placeholder="Search Course" data-column="1">
    </th>
    <th>
      <input type="text" class="form-control filter-input" placeholder="Search Year" data-column="2">
    </th>
    <th>
      <input type="text" class="form-control filter-input" placeholder="Search Trimester" data-column="3">
    </th>
    <th>
      <input type="text" class="form-control filter-input" placeholder="Search Campus" data-column="4">
    </th>
    <th>
      <input type="text" class="form-control filter-input" placeholder="Search Convenor" data-column="5">
    </th>
    <th>
      <input type="text" class="form-control filter-input" placeholder="Search Notes" data-column="6">
    </th>
    <tr>
      <th>Code</th>
      <th>Course</th>
      <th>Year</th>
      <th>Trimester</th>
      <th>Campus</th>
      <th>Convenors</th>
      <th>Notes</th>
        <th>Select</th>

    </tr>
  </thead>
  <tbody>
    @foreach($offerings as $offering)
    <tr>
        <input type="hidden" name="id[]" value="{{$offering->id}}">
      <td><input class="form-control" type="text" name="code[]"   value="{{$offering->course->code}}"></td>
      <td><input class="form-control" type="text" name="name[]"   value="{{$offering->course->name}}"></td>
      <td><input class="form-control" type="text" name="year[]"   value="{{$offering->year}}"></td>
      <td><input class="form-control" type="text" name="trimester[]" value="{{$offering->trimester}}"></td>
      <td>
        <select class="form-control" name="campus[]">
        @foreach($campuses as $campus)
          <option value="{{$campus}}" {{$offering->campus == $campus ? 'selected' : ''}}>{{$campus}}</option>
        @endforeach
        </select>
      </td>
      <td>
          <select class="selectpicker form-control" name="academic_id[{{ $offering->id }}][]" multiple data-selected-text-format="count > 2">
              @php
                  $offeringAcademicIds = $offering->academics->pluck('id')->toArray();
              @endphp
              @foreach ($academics as $academic)
                  <option
                      value="{{ $academic->id }}"
                      class="dropdown-item custom-tooltip"
                      {{ in_array($academic->id, $offeringAcademicIds) ? 'selected' : '' }}>
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

</form>

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
@endsection
