@extends('layouts.master')

@section('title')
  Add Cotaught Course
@endsection

@section('content')
  <h1>Add Cotaught Course</h1>
  Add a co_taught course with {{$this_course->code}}{{$this_course->name}}

  <form method="post" action="{{url("course/cotaught/$this_course->id")}}">
    {{csrf_field()}}
    <div class="form-group">
      <label>Co_taught with</label>
      <select name="co_taught" class="form-control">
        @foreach($courses as $course)
          <option value="{{$course->id}}">{{$course->code}}, {{$course->name}}</option>
        @endforeach
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
@endsection