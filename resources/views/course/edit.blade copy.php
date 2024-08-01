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
  <form method="post" action="{{url("course/$course->id")}}">
    {{csrf_field()}}
    {{ method_field('PUT') }}
    <div class="form-group">
      <label>Course Code (required)</label>
      <input type="text" name="code" class="form-control" value="{{old('code', $course->code)}}" required>
    </div>
    <div class="form-group">
      <label>Course Name</label>
      <input type="text" class="form-control" name="name" value="{{old('name', $course->name)}}">
    </div>  

    <div class="form-group">
      <label>Prereq</label>
      <input type="text" class="form-control" name="prereq" value="{{old('prereq', $course->prereq)}}">
    </div>

    <div class="form-group">
      <label>Program: </label>
      @foreach($programs as $program)
        <div class="form-check form-check-inline">
          @if (in_array($program->name, $coursePrograms)) 
            <input type="checkbox" class="form-check-input" id="{{$program->name}}" name="{{$program->name}}" value="{{$program->id}}" checked>
          @else
            <input type="checkbox" class="form-check-input" id="{{$program->name}}" name="{{$program->name}}" value="{{$program->id}}">
          @endif
          <label class="form-check-label" for="{{$program->name}}">{{$program->name}}</label>
        </div>
      @endforeach
    </div>

    <div class="form-group">
      <label>Transition</label>
      <input type="text" class="form-control" name="transition" value="{{old('transition', $course->transition)}}">
    </div>

    <div class="form-group">
      <label>Teaching Method</label>
      <textarea type="text" class="form-control" name="tmethod">{{old('tmethod', $course->tmethod)}}</textarea>
    </div>

    <div class="form-group">
      <label>Note</label>
      <textarea type="text" class="form-control" name="note">{{old('note', $course->note)}}</textarea>
    </div>

    <button type="submit" class="btn btn-success">Submit</button>

  </form>
@endsection