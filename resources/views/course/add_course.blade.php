@extends('layouts.master')

@section('title')
  Add Course
@endsection

@section('content')
  <h1>Add Course</h1>
  @if (count($errors) > 0)
    <div class="alert">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <form method="post" action="{{url("course")}}">
    {{csrf_field()}}
    <div class="form-group">
      <label>Course Code (required)</label>
      <input type="text" name="code" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Course Name</label>
      <input type="text" class="form-control" name="name">
    </div>  

    <div class="form-group">
      <label>Prereq</label>
      <input type="text" class="form-control" name="prereq">
    </div>

    {{-- <div class="form-group">
      <label>Program: </label>
      @foreach($programs as $program)
        <div class="form-check form-check-inline">
          <input type="checkbox" class="form-check-input" id="{{$program->name}}" name="{{$program->name}}" value="{{$program->id}}">
          <label class="form-check-label" for="{{$program->name}}">{{$program->name}}</label>
        </div>
      @endforeach
    </div> --}}

    <div class="form-group">
      <label>Transition</label>
      <input type="text" class="form-control" name="transition">
    </div>

    <div class="form-group">
      <label>Teaching Methods</label>
      <textarea type="text" class="form-control" name="tmethod"></textarea>
    </div>

    <div class="form-group">
      <label>Note</label>
      <textarea type="text" class="form-control" name="note"></textarea>
    </div>

    <button type="submit" class="btn btn-outline-success"><i class="fa-regular fa-circle-check"></i> Submit</button>

  </form>
@endsection