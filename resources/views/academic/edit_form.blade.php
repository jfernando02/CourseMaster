@extends('layouts.master')

@section('title')
  Edit Academics
@endsection

  @section('content')
  <h1>Update Academic</h1>
  @if (count($errors) > 0)
    <div class="alert">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  @if(session('error'))
    <h6 class="text-danger">Error: {{session('error')}}</h6>
  @endif
  <form method="POST" action="{{ route('academic.save') }}">
    @csrf
      <div class='row'>
          <div class="d-flex justify-content-between">

              <a class="btn btn-outline-primary" href="{{ url('academic/create') }}"><i class="fa-regular fa-plus"></i> Add a new academic</a>

      <button class="btn btn-outline-danger" type="submit" name="delete" value="delete" onclick="return confirm('Are you sure you want to delete these academics?')">
          <i class="fa-regular fa-trash"></i> Delete Selected Academics

          <button type="submit" class="btn btn-outline-success"><i class="fa-regular fa-floppy-disk"></i>  Save</button>
      </button>

          </div>
      </div>
    <table class="table table-hover" id="academicTable">
    <thead>
      <tr>
        <th>
            <input type="text" class="form-control filter-input" placeholder="Search Firstname" data-column="0">
        </th>
        <th>
            <input type="text" class="form-control filter-input" placeholder="Search Lastname" data-column="1">
        </th>
          <th>
              <input type="text" class="form-control filter-input" placeholder="Search Email" data-column="2">
          </th>
        <th>
            <input type="text" class="form-control filter-input" placeholder="Search Teaching Load" data-column="3">
        </th>
          <th>
              <input type="text" class="form-control filter-input" placeholder="Search Teaching Load (Year)" data-column="4">
          </th>
        <th>
            <input type="text" class="form-control filter-input" placeholder="Search Area" data-column="5">
        </th>
        <th>
            <input type="text" class="form-control filter-input" placeholder="Search Home Campus" data-column="6">
        </th>
        <th>
            <input type="text" class="form-control filter-input" placeholder="Search Note" data-column="7">
        </th>
          </tr>
        <tr>

            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Teaching Load (Trimester)</th>
            <th>Teaching Load (Year)</th>
            <th>Area</th>
            <th>Home Campus</th>
            <th>Note</th>
            <th>Select</th>
        </tr>
    </thead>
    <tbody>
        @foreach($academics as $academic)
        <tr>
            <input type="hidden" name="id[]" value="{{$academic->id}}">
          <td><input class="form-control" type="text" name="firstname[]" value="{{$academic->firstname}}"></td>
          <td><input class="form-control" type="text" name="lastname[]" value="{{$academic->lastname}}"></td>
            <td><input class="form-control" type="text" name="email[]" value="{{$academic->email}}"></td>
          <td><input class="form-control" type="text" name="teaching_load[]" value="{{$academic->teaching_load}}"></td>
            <td><input class="form-control" type="text" name="yearly_teaching_load[]" value="{{$academic->yearly_teaching_load}}"></td>
          <td><input class="form-control" type="text" name="area[]" value="{{$academic->area}}"></td>
          <td>
            <select class="form-control" name="home_campus[]">
              @foreach($campuses as $campus)
                <option value="{{$campus}}" {{$academic->home_campus == $campus ? 'selected' : ''}}>{{$campus}}</option>
              @endforeach
            </select>
          </td>
          <td><input class="form-control" type="text" name="note[]" value="{{$academic->note}}"></td>
            <td><div class="form-check">
                <input class="btn btn-outline-success" type="checkbox" name="save_row[]" value="{{ $academic->id }}">
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
      const rows = document.querySelector("#academicTable tbody").rows;

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
