@extends('layouts.master')

@section('title')
  Edit Courses
@endsection

@section('content')
  <h1>Edit Courses</h1>
  @if (count($errors) > 0)
    <div class="alert">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <a class="btn btn-outline-primary" href="{{ url('course/create') }}"><i class="fa-regular fa-plus"></i> Add a new course</a>
  <form method="post" action="{{ route('course.save') }}">



    @csrf
      <button class="btn btn-outline-danger" type="submit" name="delete" value="delete" onclick="return confirm('Are you sure you want to delete these courses?')">
          <i class="fa-regular fa-trash"></i> Delete Selected Courses
      </button>
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
                <input type="text" class="form-control filter-input" placeholder="Search Primary Convener" data-column="3">
            </th>
            <th>
              <input type="text" class="form-control filter-input" placeholder="Search Note" data-column="5">
            </th>
        <tr>
          <th>Code</th>
          <th>Name</th>
          <th>Course Level</th>
          <th>Superseded By</th>
            <th>Primary Convener</th>
          <th>Note</th>
            <th>Select</th>
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
                <div class="form-group">
                    <select class="selectpicker form-control" name="academic_id[]">
                        {{-- <option
                        title="ddd"
                        >Select Lecturer</option> --}}
                        <option value="">Unassigned</option>
                        @foreach ($academics as $academic)
                            <option

                                class="dropdown-item custom-tooltip"
                                value="{{ $academic->id }}" @if ($academic->id == $course->academic_id) selected @endif
                            >
                                {{ $academic->firstname }} {{ $academic->lastname }} ({{$academic->home_campus}})
                            </option>
                        @endforeach
                    </select>
                </div>
            </td>
          <td>
            <input class="form-control type="text" name="note[]" value="{{ $course->note }}">
          </td>
            <td><div class="form-check">
                    <input class="btn btn-outline-success" type="checkbox" name="save_row[]" value="{{ $course->id }}">
                </div></td>
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
