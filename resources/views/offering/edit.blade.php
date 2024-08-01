@extends('layouts.master')

@section('title')
  Edit Offering
@endsection

@section('content')
  <h1>Edit Offering for {{$course->code}} {{$course->name}}</h1>
  <form method="post" action="{{url("offering/$offering->id")}}">
    {{csrf_field()}}
    {{ method_field('PUT') }}
    <div class="form-group">
      <label>Year (required)</label>
      <input type="number" name="year" class="form-control" value="{{old('year', $offering->year)}}" required>
    </div>
    <div class="form-group">
      <label>Trimester (required)</label>
      <select name="trimester" class="form-control" required>
          <option value="1" @if (old('trimester', $offering->trimester) == 1) selected @endif>1</option>
          <option value="2" @if (old('trimester', $offering->trimester) == 2) selected @endif>2</option>
          <option value="3" @if (old('trimester', $offering->trimester) == 3) selected @endif>3</option>
      </select>   
    </div>  
    <div class="form-group">
      <label>Campus (required)</label>
      <select name="campus" class="form-control" required>
          <option value="GC" @if (old('campus', $offering->campus) == "GC") selected @endif>GC</option>
          <option value="NA" @if (old('campus', $offering->campus) == "NA") selected @endif>NA</option>
          <option value="OL" @if (old('campus', $offering->campus) == "OL") selected @endif>OL</option>
      </select>
    </div>

    <div class="form-group">
      <label>Convenor</label>
      <select name="convenor" class="form-control">
        @foreach($academics as $academic)
          <option value="{{$academic->id}}"
            @if ($academic->id == $offering->convenor->id)
                selected
            @endif
          >{{$academic->lastname}}, {{$academic->firstname}}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label>Primary convenor</label>
      <select name="primary" class="form-control">
          <option value="1" @if (old('primary', $offering->primary) == true) selected @endif>Yes</option>
          <option value="0" @if (old('primary', $offering->primary) == false) selected @endif>No</option>
      </select>
    </div>

    <div class="form-group">
      <label>Count towards teaching load?</label>
      <select name="tcount" class="form-control">
          <option value="1" @if (old('tcount', $offering->tcount) == true) selected @endif>Yes</option>
          <option value="0" @if (old('tcount', $offering->tcount) == false) selected @endif>No</option>
      </select>
    </div>

    <div class="form-group">
      <label>Number of students (post census)</label>
      <input type="number" name="nstudents" class="form-control" value="{{old('nstudents', $offering->nstudents)}}">
    </div>

    <div class="form-group">
      <label>Lecture hours</label>
      <input type="number" name="nlectures" class="form-control" value="{{old('nlectures', $offering->nlectures)}}">
    </div>

    <div class="form-group">
      <label>Workshop hours</label>
      <input type="number" name="nworkshops" class="form-control" value="{{old('nworkshops', $offering->nworkshops)}}">
    </div>

    <!-- create TAT hours -->

    <div class="form-group">
      <label>TAT hours</label>
      <input type="number" name="TAThours" class="form-control" value="{{old('TAThours', $offering->TAThours)}}">

    <!-- create lecture day editing -->
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Lecture day</label>
        <div class="col-sm-10"> 
        <select class="col-sm-10" name="lectureday" class="form-control">
            <option value="Monday" @if (old('lectureday', $offering->lecture_day) == "Monday") selected @endif>Monday</option>
            <option value="Tuesday" @if (old('lectureday', $offering->lecture_day) == "Tuesday") selected @endif>Tuesday</option>
            <option value="Wednesday" @if (old('lectureday', $offering->lecture_day) == "Wednesday") selected @endif>Wednesday</option>
            <option value="Thursday" @if (old('lectureday', $offering->lecture_day) == "Thursday") selected @endif>Thursday</option>
            <option value="Friday" @if (old('lectureday', $offering->lecture_day) == "Friday") selected @endif>Friday</option>
        </select>
        </div>

    <div class="form-group">
      <label>Lecture start time</label>
      <input type="time" name="lecturestarttime" class="form-control" value="{{old('lecturestarttimee', $offering->llecture_start_time)}}">
    </div>

    <div class="form-group">
      <label>Lecture end time</label>
      <input type="time" name="lectureendtime" class="form-control" value="{{old('lectureendtime', $offering->lecture_end_time)}}">
    </div>

    <!-- create workshop day editing -->
    <div class="form-group row">
      <label class="col-sm-2 col-form-label">Workshop day</label>
        <div class="col-sm-10"> 
        <select class="col-sm-10" name="workshopday" class="form-control">
            <option value="Monday" @if (old('workshopday', $offering->workshop_day) == "Monday") selected @endif>Monday</option>
            <option value="Tuesday" @if (old('workshopday', $offering->workshop_day) == "Tuesday") selected @endif>Tuesday</option>
            <option value="Wednesday" @if (old('workshopday', $offering->workshop_day) == "Wednesday") selected @endif>Wednesday</option>
            <option value="Thursday" @if (old('workshopday', $offering->workshop_day) == "Thursday") selected @endif>Thursday</option>
            <option value="Friday" @if (old('workshopday', $offering->workshop_day) == "Friday") selected @endif>Friday</option>
        </select>
        </div>

    <div class="form-group">
      <label>Workshop start time</label>
      <input type="time" name="workshopstarttime" class="form-control" value="{{old('workshopstarttime', $offering->workshop_start_time)}}">
    </div>

    <div class="form-group">
      <label>Workshop end time</label>
      <input type="time" name="workshopendtime" class="form-control" value="{{old('workshopendtime', $offering->workshop_end_time)}}">
    </div>
    

    <div class="form-group">
      <label>Note</label>
      <textarea type="text" class="form-control" name="note">{{old('note', $offering->note)}}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>

  </form>



@endsection