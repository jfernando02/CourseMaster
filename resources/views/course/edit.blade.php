@extends('layouts.master')

@section('title')
  Edit Course
@endsection

@section('content')
  <h1>Edit Course</h1>
  @if (count($errors) > 0)
    <div class="alert">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <form method="post" action="{{ route('course.save') }}">



    @csrf

    <table class="table table-hover" id="coursesTable">
      <thead>
        <tr>
            <th>
              <input type="text" class="form-control filter-input" placeholder="Search Code" data-column="0">
            </th>
            <th>
              <input type="text" class="form-control filter-input" placeholder="Search Name" data-column="1">
            </th>
            <th>
              <input type="text" class="form-control filter-input" placeholder="Search Level" data-column="2">
            </th>
            <th>
              <input type="text" class="form-control filter-input" placeholder="Search Transition" data-column="3">
            </th>
            <th>
              <input type="text" class="form-control filter-input" placeholder="Search Teaching Method" data-column="4">
            </th>
            <th>
              <input type="text" class="form-control filter-input" placeholder="Search Note" data-column="5">
            </th>
        <tr>
          <th>Code</th>
          <th>Name</th>
          <th>Course Level</th>
          <th>Superseded By</th>
          <th>Teaching Method</th>
          <th>Note</th>
        </tr>
      </thead>
      <tbody>
        @foreach($courses as $course)
        <tr>
          <input class="form-control" type="hidden" name="id[]" value="{{ $course->id }}">

          <td>
            <input class="form-control type="text" name="code[]" value="{{ $course->code }}">
          </td>
          <td>
            <input class="form-control type="text" name="name[]" value="{{ $course->name }}">
          </td>
          <td>
            {{-- <input class="form-control type="text" name="prereq[]" value="{{ $course->prereq }}"> --}}
            <select class="form-control" name="courseLevel[]">
              <option value="" {{ $course->course_level == '' ? 'selected' : '' }}></option>
              <option value="Undergraduate" {{ $course->course_level == 'Undergraduate' ? 'selected' : '' }}>Undergraduate</option>
              <option value="Postgraduate" {{ $course->course_level == 'Postgraduate' ? 'selected' : '' }}>Postgraduate</option>
            </select>
          </td>
          <td>
            {{-- <input class="form-control type="text" name="transition[]" value="{{ $course->transition }}"> --}}
            {{-- should be a select of all courses --}}
            <select class="form-control" name="transition[]">
              <option value="" {{ $course->transition == '' ? 'selected' : '' }}></option>
              @foreach($courses as $c)
                <option value="{{ $c->code }}" {{ $course->transition == $c->code ? 'selected' : '' }}>{{ $c->code }}</option>
              @endforeach
            </select>
          </td>
          <td>
            <input class="form-control type="text" name="tmethod[]" value="{{ $course->tmethod }}">
          </td>
          <td>
            <input class="form-control type="text" name="note[]" value="{{ $course->note }}">
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <button type="submit" class="btn btn-outline-success"><i class="fa-regular fa-floppy-disk"></i> Save</button>
  </form>


  <script>


document.addEventListener('DOMContentLoaded', function() {
  const filters = document.querySelectorAll('.filter-input');

  filters.forEach(filter => {
    filter.addEventListener('keyup', function() {
      const rows = document.querySelector("#coursesTable tbody").rows;
      const currentColumnIndex = parseInt(this.getAttribute('data-column'));
      const query = this.value.toLowerCase();

      for (let row of rows) {
        let showRow = true; 

        filters.forEach(filter => {
          if (filter.value !== '') { 
            const colIndex = parseInt(filter.getAttribute('data-column'));
            const cell = row.cells[colIndex];
            let textContent = '';

            if (cell.querySelector('input')) {
              textContent = cell.querySelector('input').value.toLowerCase();
            } else if (cell.querySelector('select')) {
              const select = cell.querySelector('select');
              textContent = select.options[select.selectedIndex].text.toLowerCase();
            } else {
              textContent = cell.textContent.toLowerCase();
            }

            if (!textContent.includes(filter.value.toLowerCase())) {
              showRow = false;
            }
          }
        });

        row.style.display = showRow ? '' : 'none'; 
      }
    });
  });
});

    </script>
@endsection