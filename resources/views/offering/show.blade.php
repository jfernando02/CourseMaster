@extends('layouts.master')

@section('title')
  Offering detail
@endsection
 
@section('content')
    <a class="btn btn-outline-primary" href="{{url("course")}}">Course List</a> 
    <div class="vr"></div>
    <a class="btn btn-warning" href="{{url("offering/$offering->id/edit")}}">Edit</a>    
    <form method="POST" action= '{{url("offering/$offering->id")}}' style="display: inline;">
      {{csrf_field()}}
      {{ method_field('DELETE') }}
      <input type="submit" value="Delete" class="btn btn-danger" onclick="return confirm('{{ __('Are you sure you want to delete this offering?') }}')">
    </form>

    @if(session('error'))
    <h6 class="text-danger">Error: {{session('error')}}</h6>
    @endif
    <hr>
    <h4>{{$course->code}} {{$course->name}}</h4>

    <dl class="row">
      <dt class="col-sm-3">Year</dt>
      <dd class="col-sm-9">{{$offering->year}}</dd>  

      <dt class="col-sm-3">Trimester</dt>
      <dd class="col-sm-9">{{$offering->trimester}}</dd> 

      <dt class="col-sm-3">Campus</dt>
      <dd class="col-sm-9">{{$offering->campus}}</dd>  

      <dt class="col-sm-3">Convenor</dt>
      <dd class="col-sm-9">

      @if(isset($academic))
          <a href='{{url("academic/$academic->id")}}'>
          {{$academic->firstname}} {{$academic->lastname}}</a>
      @else Unassigned
      @endif

{{--       @if(isset($offering->convenor))
      <a href='{{url("academic/{{$offering->convenor->id}}")}}'>
      {{$offering->convenor->firstname}} {{$offering->convenor->lastname}}</a>
  @else Unassigned
  @endif --}}

      </dd>  

      <dt class="col-sm-3">Primary Convenor</dt>
      <dd class="col-sm-9">
        @if($offering->primary) Yes
        @else No
        @endif
      </dd>  

      <dt class="col-sm-3">Count teaching load</dt>
      <dd class="col-sm-9">
        @if($offering->tcount) Yes
        @else No
        @endif
      </dd>

      <br>
      <br>
      <br>


      <table class="table">
            <thead>
              <tr>
                <th>Lecturer</th>
                <th>Class day</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>No. of Students</th>
              </tr>
            </thead>
            <tbody>
              @foreach($classes as $class)
              <tr>
                <td>{{$class->academic->firstname}} {{$class->academic->lastname}}</td>
                <td>{{$class->class_day}}</td>
                <td>{{$class->start_time}}</td>
                <td>{{$class->end_time}}</td>
                <td>{{$class->numberOfStudents}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          
    </dl>
{{--     <p>Prereq : {{$course->prereq}}</p>
    <p>Program : 
      @foreach ($course->programs as $program)  
        {{$program->name}} 
      @endforeach
    </p>
    <p>Transition : {{$course->transition}}</p>
    <p>Note : {{$course->note}}</p>
    @if (!empty($cotaughts))
      <p>Cotaught with 
      @foreach($cotaughts as $cotaught)
        <a href="{{url("course/$cotaught->id")}}"> {{$cotaught->code}} {{$cotaught->name}}</a> 
      @endforeach
      </p>
    @endif --}}


@endsection