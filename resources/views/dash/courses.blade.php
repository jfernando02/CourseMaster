@extends('layouts.master')

@section('title')
    Course dashboard
@endsection
 
@section('content')
<h2>{{$year}} Trimester {{$tri}} </h2>
<table class ="table">
  <thead>
    <tr>
      <th scope="col">Code</th>
      <th scope="col">Name</th>
      <th scope="col">Cotaught</th>
      <th scope="col">GC</th>
      <th scope="col">NA</th>
      <th scope="col">OL</th>
    </tr>
  </thead>
  <tbody>
    @foreach($courses_offerings as $course_offerings)
      <tr>
        <td><a href="{{url("course/{$course_offerings[0]->course->id}")}}">{{$course_offerings[0]->course->code}}</a></td>
        <td>{{$course_offerings[0]->course->name}}</td>
        <td>
          @forelse($course_offerings[0]->course->cotaught() as $cotaught)
            <a href="{{url("course/{$cotaught->id}")}}">{{$cotaught->code}}</a> 
          @empty
             None 
          @endforelse 
        </td>
        @foreach($course_offerings as $offering)
          <td> 
          @if ($offering->academic)
            <a href="{{url("academic/{$offering->academic->id}")}}">{{$offering->academic->lastname}} {{$offering->academic->firstname}}</a>
            @if ($offering->primary)
            *
            @endif
          @endif
          </td>
        @endforeach
      </tr>
    @endforeach
  </tbody>
</table>
@endsection