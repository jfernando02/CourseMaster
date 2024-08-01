@extends('layouts.master')

@section('title')
  Home
@endsection
 
@section('content')

  @if ($courses->isNotEmpty())
    <h3>Matching courses</h3>  
    <ul>
    @foreach($courses as $course)
      <li><a href="{{url("course/$course->id")}}">{{$course->code}} {{$course->name}}</a></li>
    @endforeach
    </ul>
  @endif  

  @if ($academics->isNotEmpty())
    <h3>Matching Academics</h3>
    <ul>
    @foreach($academics as $academic)
      <li><a href="{{url("academic/$academic->id")}}">{{$academic->lastname}}, {{$academic->firstname}}</a></li>
    @endforeach
    </ul>
  @endif  
@endsection
