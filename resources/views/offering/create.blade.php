@extends('layouts.master')

@section('title')
  Add Offering
@endsection

@section('content')
@if (count($errors) > 0)
<div class="alert">
  <ul>
    @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif
@if(session('error'))
<h6 class="text-danger">Error: {{session('error')}}</h6>
@endif
  <h1>Add Offering for {{$course->code}} {{$course->name}}</h1>
  <form method="post" action="{{url("offering/$course->id")}}">
    {{csrf_field()}}
    <div class="form-group">
      <label>Year (required) *</label>
      <input type="number" name="year" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Trimester (required)</label>
      <select name="trimester" class="form-control" required>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
      </select>   
    </div>  
    <div class="form-group">
      <label>Campus (required)</label>
      <select name="campus" class="form-control" required>
          <option value="GC">GC</option>
          <option value="NA">NA</option>
          <option value="OL">OL</option>
      </select>
    </div>

    <div class="form-group">
      <label>Convenor</label>
      <select name="convenor" class="form-control">
        @foreach($academics as $academic)
          <option value="{{$academic->id}}">{{$academic->lastname}}, {{$academic->firstname}}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label>Primary convenor</label>
      <select name="primary" class="form-control">
          <option value="1">Yes</option>
          <option value="0">No</option>
      </select>
    </div>

    <div class="form-group">
      <label>Count towards teaching load?</label>
      <select name="tcount" class="form-control">
          <option value="1">Yes</option>
          <option value="0">No</option>
      </select>
    </div>

    <div class="form-group">
      <label>Number of students (post census)</label>
      <input type="number" name="nstudents" class="form-control" >
    </div>


    <div class="form-group">
      <label>Lecture hours</label>
      <input type="number" name="nlectures" class="form-control" >
    </div>
    
    <div class="form-group">
      <label>Workshop hours</label>
      <input type="number" name="nworkshops" class="form-control" >
    </div>



    <div class="form-group">
      <label>TAT hours</label>
      <input type="number" name="TAThours" class="form-control" >     
    </div>

    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Lecture day</label>
        <div class="col-sm-10"> 
        <select class="col-sm-10" name="lectureday" class="form-control">
          <option value="Monday">Monday</option>
          <option value="Tuesday">Tuesday</option>
          <option value="Wednesday">Wednesday</option>
          <option value="Thursday">Thursday</option>
          <option value="Friday">Friday</option>
        </select>   
        </div>
    </div>


        <div class="form-group">
      <label>Lecture start time (HH:MM AM/PM)</label>
      <input type="time" name="lecturestarttime" class="form-control" >
    </div>
    <div class="form-group">
      <label>Lecture end time  (HH:MM AM/PM)</label>
      <input type="time" name="lectureendtime" class="form-control" >
    </div>

    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Workshop day</label>
        <div class="col-sm-10"> 
        <select class="col-sm-10" name="workshopday" class="form-control">
          <option value="Monday">Monday</option>
          <option value="Tuesday">Tuesday</option>
          <option value="Wednesday">Wednesday</option>
          <option value="Thursday">Thursday</option>
          <option value="Friday">Friday</option>
        </select>   
        </div>
    </div>


    <div class="form-group">
      <label>Workshop start time  (HH:MM AM/PM)</label>
      <input type="time" name="workshopstarttime" class="form-control" >
    </div>
    <div class="form-group">
      <label>Workshop end time  (HH:MM AM/PM)</label>
      <input type="time" name="workshopendtime" class="form-control" >
    </div>
    <!-- end input start time and end time -->
    
    





    <div class="form-group">
      <label>Note</label>
      <textarea type="text" class="form-control" name="note"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>

  </form>
@endsection