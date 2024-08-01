@extends('layouts.master')

@section('title')
  Course detail
@endsection
 
@section('content')
    <a class="btn btn-outline-primary" href="{{url("course")}}">Course List</a> 
    <div class="vr"></div>
    <a class="btn btn-warning" href="{{url("course/$course->id/edit")}}">Edit</a>    
    <form method="POST" action= '{{url("course/$course->id")}}' style="display: inline;">
      {{csrf_field()}}
      {{ method_field('DELETE') }}
      <input type="submit" value="Delete" class="btn btn-danger" onclick="return confirm('{{ __('Are you sure you want to delete this course?') }}')">
    </form>
    <a class="btn btn-dark" href="{{url("course/add_cotaught/$course->id")}}">Add Cotaught</a>
    <div class="vr"></div>
    <a class="btn btn-success" href="{{url("offering/$course->id/create")}}">Add Offering</a> 

    @if(session('error'))
    <h6 class="text-danger">Error: {{session('error')}}</h6>
    @endif

    <h1>{{$course->code}} {{$course->name}}</h1>
    <dl class="row">
      <dt class="col-sm-3">Prereq</dt>
      <dd class="col-sm-9">{{$course->prereq}}</dd>  

      <dt class="col-sm-3">Program</dt>
      <dd class="col-sm-9">      
        @foreach ($course->programs as $program)  
          {{$program->name}} 
        @endforeach
      </dd> 

      <dt class="col-sm-3">Transition</dt>
      <dd class="col-sm-9">{{$course->transition}}</dd> 

      <dt class="col-sm-3">Teaching method</dt>
      <dd class="col-sm-9"> {{$course->tmethod}}</dd> 

      <dt class="col-sm-3">Note</dt>
      <dd class="col-sm-9">{{$course->note}}</dd> 

      <dt class="col-sm-3">Cotaught with </dt>
      <dd class="col-sm-9">
        @if (!empty($cotaughts))
          @foreach($cotaughts as $cotaught)
            <a href="{{url("course/$cotaught->id")}}"> {{$cotaught->code}} {{$cotaught->name}}</a> 
          @endforeach
        @endif
      </dd> 
    </dl>

    <hr>
    <h2>Offerings</h2>
    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
          <th scope="col">Year</th>
          <th scope="col">T1</th>
          <th scope="col">T2</th>
          <th scope="col">T3</th>
        </tr>
      </thead>
   
      <tbody>
          @foreach($years_offerings as $year => $year_offerings)
            <tr>
            <th scope="row">{{$year}}</th>
            @foreach ($year_offerings as $trimester_offerings)
              <td> 
                @foreach($trimester_offerings as $offering_campus)
                <a href="{{url("offering/$offering_campus->id")}}">{{$offering_campus->campus}}:
                  @isset($offering_campus->academic)
                    {{$offering_campus->academic->lastname}}
                  @endisset
                </a>
                  @if (!$loop->last)
                    &nbsp<span class="vr"></span>
                  @endif
                @endforeach 
              </td>
            @endforeach
{{--             <td> 
              @foreach($year_offerings['2'] as $offering_campus)
                {{$offering_campus->campus}}
              @endforeach
            </td>
            <td> 
              @foreach($year_offerings['3'] as $offering_campus)
                {{$offering_campus->campus}}
              @endforeach
            </td>
            </tr> --}}
          @endforeach
      </tbody>
    </table>  


@endsection