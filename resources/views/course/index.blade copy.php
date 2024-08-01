@extends('layouts.master')

@section('title')
  Course list
@endsection
 
@section('content')
<a class="btn btn-warning" href="{{url("course/create")}}">Add a new course</a>
<h1>Courses</h1>
  @if ($courses)
    <ul>
    @foreach($courses as $course)
      <li><a href="{{url("course/$course->id")}}">{{$course->code}} {{$course->name}}</a></li>
    @endforeach
    </ul>
  @else
    No item found
  @endif  
@endsection
