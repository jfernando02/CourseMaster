@extends('layouts.master')

@section('title')
  Academic list
@endsection
 
@section('content')
<a class="btn btn-warning" href="{{url("academic/create")}}">Add a new academic</a>
<h1>Academics</h1>
  @if ($academics)
    <ul>
    @foreach($academics as $academic)
      <li><a href="{{url("academic/$academic->id")}}">{{$academic->lastname}}, {{$academic->firstname}}</a></li>
    @endforeach
    </ul>
  @else
  No item found
  @endif

<div>
<div class="container">
    <!-- <h1>Edit Academics</h1> -->
    <div class="form-group">
      <form method="POST" action="{{ url('academic/toggle-offerings') }}">
          <label for="toggle">Display Assigned Offerings</label>
          @csrf
          <button type="submit" name="toggle" value="{{ session('displayAssignedOfferings', false) ? '0' : '1' }}" class="btn btn-primary">
              Update Assigned Offerings per Trimester
          </button>
          <label for="trimester">Trimester</label>
          <select id="trimester" name="trimester">
            @foreach($offering_trimester as $offering)
              <option value="{{$offering->year}}-{{$offering->trimester}}">{{$offering->year}}-{{$offering->trimester}}</option>
            @endforeach
    
          </select>
      </form>


    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Teaching Load</th>
                <th>Area</th>
                <th>Course</th>
                <th>Campus</th>
            </tr>
        </thead>
        <tbody>
            @foreach($academics as $academic)
            <tr>
                <td contenteditable>{{ $academic->firstname }} {{ $academic->lastname }}</td>
                <td contenteditable>{{ $academic->teaching_load }}</td>
                <td contenteditable>{{ $academic->area }}</td>
                <td contenteditable> 
                  @foreach($academic->offerings->where('year', $offering->year)->where('trimester', $offering->trimester) as $offering)
                    <p>{{ $offering->course->name }}</p>
                  @endforeach
                </td>
                <td contenteditable>
                      @foreach($academic->offerings->where('year', $offering->year)->where('trimester', $offering->trimester) as $offering)
                        <p>{{$offering->campus }}</p>
                      @endforeach
                </td>          
            </tr>
            @endforeach
        </tbody>
    </table>


    @if ($unassigned_academics)
      <h1>Unassigned Academics</h1>
      <table class="table table-striped">
        <thead>
          <tr>
                <th>Name</th>
                <th>Teaching Load</th>
                <th>Area</th>
                <th>Course</th>
                <th>Campus</th>
            </tr>
          </tr>
        </thead>
        <tbody>
          @foreach($unassigned_academics as $academic)
          <tr>
            <td contenteditable>{{ $academic->firstname }} {{ $academic->lastname }}</td>
            <td contenteditable>{{ $academic->teaching_load }}</td>
            <td contenteditable>{{ $academic->area }}</td>
            <td>
                  @foreach($academic->offerings->where('year', $offering->year)->where('trimester', $offering->trimester) as $offering)
                    <p>{{ $offering->course->name }}</p>
                  @endforeach
                </td>
                <td contenteditable>
                      @foreach($academic->offerings->where('year', $offering->year)->where('trimester', $offering->trimester) as $offering)
                        <p>{{$offering->campus }}</p>
                      @endforeach
                </td>        
            </tr>
          @endforeach
        </tbody>
    </table>
    @endif
</div>


</div>

@endsection
