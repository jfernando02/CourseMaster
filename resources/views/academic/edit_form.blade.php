@extends('layouts.master')

@section('title')
  Update Academic
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
  <a class="btn btn-outline-primary" href="{{ url('academic/create') }}"><i class="fa-regular fa-plus"></i> Add a new academic</a>
  <form method="POST" action="{{ route('academic.save') }}">
    @csrf
    <table class="table table-hover" id="academicTable">
    <thead>
      <tr>
        <th>
            <input type="text" class="form-control filter-input" placeholder="Search IDs" data-column="0">
        </th>
        <th>
            <input type="text" class="form-control filter-input" placeholder="Search Firstname" data-column="1">
        </th>
        <th>
            <input type="text" class="form-control filter-input" placeholder="Search Lastname" data-column="2">
        </th>
          <th>
              <input type="text" class="form-control filter-input" placeholder="Search Email" data-column="3">
          </th>
        <th>
            <input type="text" class="form-control filter-input" placeholder="Search Teaching Load" data-column="4">
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

            <th>ID</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Teaching Load</th>
            <th>Area</th>
            <th>Home Campus</th>
            <th>Note</th>
        </tr>
    </thead>
    <tbody>
        @foreach($academics as $academic)
        <tr>
          <td><input class="form-control" type="text" name="id[]" value="{{$academic->id}}" readonly>
          <td><input class="form-control" type="text" name="firstname[]" value="{{$academic->firstname}}"></td>
          <td><input class="form-control" type="text" name="lastname[]" value="{{$academic->lastname}}"></td>
            <td><input class="form-control" type="text" name="email[]" value="{{$academic->email}}"></td>
          <td><input class="form-control" type="text" name="teaching_load[]" value="{{$academic->teaching_load}}"></td>
          <td><input class="form-control" type="text" name="area[]" value="{{$academic->area}}"></td>
          <td>
            <select class="form-control" name="home_campus[]">
              @foreach($campuses as $campus)
                <option value="{{$campus}}" {{$academic->home_campus == $campus ? 'selected' : ''}}>{{$campus}}</option>
              @endforeach
            </select>
          </td>
          <td><input class="form-control" type="text" name="note[]" value="{{$academic->note}}"></td>
        </tr>
        @endforeach
    </tbody>
</table>

    <button type="submit" class="btn btn-outline-success"><i class="fa-regular fa-floppy-disk"></i>  Save</button>
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
