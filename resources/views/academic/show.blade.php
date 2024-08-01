@extends('layouts.master')

@section('title')
  Academic detail
@endsection
 
@section('content')





  <a class="btn btn-outline-primary" href="{{url("academic")}}">Academic List</a> <div class="vr"></div>
  <a class="btn btn-warning" href="{{url("academic/$academic->id/edit")}}">Edit</a>    
  <form method="POST" action= '{{url("academic/$academic->id")}}' style="display: inline;">
    {{csrf_field()}}
    {{ method_field('DELETE') }}
    <input type="submit" value="Delete" class="btn btn-danger" onclick="return confirm('{{ __('Are you sure you want to delete this academic?') }}')">
  </form>
  <h1>{{$academic->firstname}} {{$academic->lastname}}</h1>
  <p>Teaching load : {{$academic->teaching_load}}</p>
  <p>Area : {{$academic->area}}</p>
  <p>Note : {{$academic->note}}</p>
  <p>Home Campus : {{$academic->home_campus}}</p>
  {{-- show table for total hours rendered per semester --}}
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Year</th>
        <th>Term</th>
        <th>Teaching Hours</th>
      </tr>
    </thead>
    <tbody>
      @foreach($teachingHours as $teachingHour)
        <tr>
          <td>{{$teachingHour['year']}}</td>
          <td>{{$teachingHour['trimester']}}</td>
          <td>{{round(round($teachingHour['hours'] * 12, 2))}}</td>
        </tr>
        </tr>
      @endforeach
    </tbody>
  </table>


  <hr>
  @if (count($academic->offerings) > 0)
    <p>Teaching Duties :</p>
    @php
      $hasGC = $academic->offerings->contains(function ($offering) {
        return $offering->campus == "GC";
      });
      $hasNA = $academic->offerings->contains(function ($offering) {
        return $offering->campus == "NA";
      });
      $hasOL = $academic->offerings->contains(function ($offering) {
        return $offering->campus == "OL";
      });
      $id = $academic->id;
    @endphp
    <div class="accordion" id="accordionExample">
      @if ($hasGC)
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
              Gold Coast Campus Teaching Load
            </button>
          </h2>
          <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              {{-- <h1>Report For  {{$offeringGC[0]->Academic->firstname}} {{$offeringGC[0]->Academic->lastname}} in {{$offeringGC[0]->campus}} Campus</h1> --}}
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Year</th>
                    <th>Term</th>
                    {{-- <th>Campus</th> --}}
                    <th>Course Name</th>
                    <th>Academic Name</th>
                    <th>Teaching Hours</th>

                  </tr>
                </thead>
                <tbody>
                  @foreach($teachingHours as $teachingHour)
                  {{-- @if ($teachingHour->academic_id == $id) --}}
                    <tr>
                      <td>{{$teachingHour->academic_id}}</td>
                      <td>{{$teachingHour->year}}</td>
                      <td>{{$teachingHour->term}}</td>
                      <td>{{$teachingHour->campus}}</td>
                      <td>{{$teachingHour->course_name}}</td>
                      <td>{{$teachingHour->academic_name}}</td>
                      <td>{{$teachingHour->teaching_hours}}</td>

                    </tr>
                  {{-- @endif --}}
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      @endif
      @if ($hasNA)
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Nathan Campus Teaching Load
            </button>
          </h2>
          <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              {{-- <h1>Report For  {{$offeringNA[0]->Academic->firstname}} {{$offeringNA[0]->Academic->lastname}} in {{$offeringNA[0]->campus}} Campus</h1> --}}
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Year</th>
                    <th>Term</th>
                    {{-- <th>Campus</th> --}}
                    <th>Course Name</th>
                    {{-- <th>Academic Name</th>           --}}
                  </tr>
                </thead>
                <tbody>
                  @foreach($offeringNA as $offering)
                    <tr>
                      <td>{{$offering->year}}</td>
                      <td>{{$offering->trimester}}</td>
                      {{-- <td>{{$offering->campus}}</td> --}}
                      <td>{{$offering->Course->name}}</td>
                      {{-- <td>{{$offering->Academic->firstname}} {{$offering->Academic->lastname}}</td> --}}
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      @endif
      @if ($hasOL)
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
              Online Campus Teaching Load
            </button>
          </h2>
          <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
            <div class="accordion-body">
              {{-- <h1>Report For  {{$offeringOL[0]->Academic->firstname}} {{$offeringOL[0]->Academic->lastname}} in {{$offeringOL[0]->campus}} Campus</h1> --}}
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Year</th>
                    <th>Term</th>
                    {{-- <th>Campus</th> --}}
                    <th>Course Name</th>
                    {{-- <th>Academic Name</th>           --}}
                  </tr>
                </thead>
                <tbody>
                  @foreach($offeringOL as $offering)
                    <tr>
                      <td>{{$offering->year}}</td>
                      <td>{{$offering->trimester}}</td>
                      {{-- <td>{{$offering->campus}}</td> --}}
                      <td>{{$offering->Course->name}}</td>
                      {{-- <td>{{$offering->Academic->firstname}} {{$offering->Academic->lastname}}</td> --}}
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      @endif
    </div>
  @endif
  <hr>
  <div>
    @foreach($years_offerings as $year_offerings)
      <h5>{{$year_offerings[0]->year}}</h5>
      @php
        $tcount = 0;
      @endphp
      @foreach($year_offerings as $offering)
        @if ($offering->tcount)
          @php
            $tcount++;
          @endphp
          <p class="text-success">
            <a href="{{url("course/$offering->course_id")}}">{{$offering->course->code}} </a>
            {{$offering->course->name}} T{{$offering->trimester}} {{$offering->campus}}
          </p>
        @else
          <p class="text-secondary">
            <a href="{{url("course/$offering->course_id")}}">{{$offering->course->code}} </a>
            {{$offering->course->name}} T{{$offering->trimester}} {{$offering->campus}}
          </p>
        @endif
      @endforeach
      Teaching load count : {{$tcount}}
      <br><br>
    @endforeach
  </div>

  {{-- list the list of classes --}}
  <div>
    <h3>Classes</h3>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          {{-- <th>Class ID</th> --}}
          <th>Year</th>
          <th>Term</th>
          <th>Campus</th>
          <th>Course Code</th>
          <th>Course Name</th>
          <th>Day</th>
          <th>Start Time</th>
          <th>End Time</th>
          <th>Delete class button</th>

        </tr>
      </thead>
      <tbody>
        @foreach($classes as $class)
          <tr>
            {{-- <td>{{$class->id}}</td> --}}
            <td>{{$class->offering->year}}</td>
            <td>{{$class->offering->trimester}}</td>
            <td>{{$class->offering->campus}}</td>
            <td>{{$class->offering->course->code}}</td>
            <td>{{$class->offering->course->name}}</td>
            <td>{{$class->class_day}}</td>
            <td>{{$class->start_time}}</td>
            <td>{{$class->end_time}}</td>
            <td>
              <form method="POST" action="{{ route('academic.delete-class-schedule', $class->id) }}" style="display: inline;">
                @csrf
                @method('POST')
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
    
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
@endsection