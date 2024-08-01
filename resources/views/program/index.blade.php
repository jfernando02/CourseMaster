@extends('layouts.master')

@section('title')
  Programs list
@endsection
 
@section('content')
<a class="btn btn-outline-primary" href="{{url("program/create")}}"><i class="fa-regular fa-plus"></i> Add a new program</a>    
<h1>Programs</h1>
  @if ($programs)
    <ul>
    @foreach($programs as $program)
      <li><a href="{{url("program/$program->id")}}">{{$program->name}} - {{$program->code}} - {{$program->fullname}}</a></li>
    @endforeach
    </ul>
  @else
    No item found
  @endif  
@endsection
