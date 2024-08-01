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

  <!-- <form method="post" action="{{url("academic/$academic->id")}}">
    {{csrf_field()}}
    {{ method_field('PUT') }}
    <div class="form-group">
      <label>First Name (required)</label>
      <input type="text" name="firstname" class="form-control" value="{{old('firstname', $academic->firstname)}}" required >
    </div>
    <div class="form-group">
      <label>Last Name (required)</label>
      <input type="text" class="form-control" name="lastname" value="{{old('lastname', $academic->lastname)}}" required>
    </div>  

    <div class="form-group">
      <label>Teaching load</label>
      <input type="number" class="form-control" name="teaching_load" value="{{old('teaching_load', $academic->teaching_load)}}">
      <small class="form-text text-muted">E.g. enter 30 for 30%</small>
    </div>

    <div class="form-group">
      <label>Expertise Area</label>
      <textarea type="text" class="form-control" name="area">{{old('area', $academic->area)}}</textarea>
    </div>

    <div class="form-group">
      <label>Note</label>
      <textarea type="text" class="form-control" name="note">{{old('note', $academic->note)}}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>

  </form> -->

  <form method="POST" action="{{ route('academic.save') }}">
    @csrf
    <table class="table">
        <thead>
            <tr>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Teaching Load</th>
                <th>Area</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach($academics as $academic)
            <tr>
                <td><input type="text" name="firstname[]" value="{{$academic->firstname}}"></td>
                <td><input type="text" name="lastname[]" value="{{$academic->lastname}}"></td>
                <td><input type="text" name="teaching_load[]" value="{{$academic->teaching_load}}"></td>
                <td><input type="text" name="area[]" value="{{$academic->area}}"></td>
                <td><input type="text" name="note[]" value="{{$academic->note}}"></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <button type="submit" class="btn btn-outline-success">Save</button>
</form>
@endsection