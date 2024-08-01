@extends('layouts.master')

@section('title')
  Reports
@endsection
 
@section('content')
<h1>Reports</h1>
<a class="btn btn-outline-primary" href="{{url("reports/create")}}"><i class="fa-regular fa-plus"></i> Create a new report</a>
<a class="btn btn-outline-primary" href="{{url("reports/reportByCampus")}}"><i class="fa-regular fa-eye"></i> View Report by Campus</a>


<form action="{{url('reports')}}" method="GET">
    <div class="form-group">
        <label for="year">Year</label>
        <input type="text" class="form-control" name="year" id="year" placeholder="Enter year">
    </div>
    <!-- make another drop down for term 1,2,3 -->
    <!-- <div class="form-group">
        <label for="term">Term</label>
        <input type="text" class="form-control" name="term" id="term" placeholder="Enter term">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>

</form> -->

    <!-- <div>
    <table class="table table-striped table-bordered">
    <thead>
        <tr>
          <th>Year</th>
          <th>Term</th>
          <th>Course Code</th>
          <th>Course Name</th>
          
          <th>Total Subjects Taught</th>
        </tr>
    </thead>
    <tbody>
        {{-- @foreach($reports as $report)
        <tr>
            <td>{{$report->Year}}</td>
            <td>{{$report->Term}}</td>
            <td>{{$report->Course_Code}}</td>
            <td>{{$report->Course_Name}}</td>
        </tr>
        @endforeach --}}
    </tbody>
    </table>
    </div> -->

    {{-- <!-- palm -->
    <div>   

        <!-- dropdown menu for list of courses -->
        
    </form>
</div>
<hr>
<h2>Teaching Staff History</h2>
<form action="{{ route('reports.teachingStaffHistory')}}" method="POST">
    @csrf
    @method('POST')
    
    <div class="form-group">
        <label for="course">Course</label>
        <select class="form-control" name="course" id="course">
            @foreach($courses as $course)
            <option value="{{$course->id}}">{{$course->code}} {{$course->name}}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-outline-success">Submit</button>
    <hr>

<table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
            <th scope="col">Course Code</th>
            <th scope="col">Course Name</th>
            <th scope="col">Teaching Staff</th>
            <th scope="col">Campus</th>
            <th scope="col">Year</th>
            <th scope="col">Trimester</th>

            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
            <tr>
            <td>{{$report->Course_Code}}</td>
            <td>{{$report->Course_Name}}</td>
            <td>{{$report->Academic_Name}}</td>
            <td>{{$report->Campus}}</td>
            <td>{{$report->Year}}</td>
            <td>{{$report->Term}}</td>

            </tr>
            @endforeach
        </tbody>
        </table>
    </div>



     --}}

@endsection
