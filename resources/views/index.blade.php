@extends('layouts.master')

@section('title')
  Home
@endsection




@section('content')

<div>


  <h1>Welcome to CourseMaster</h1>
  <h2>Hi, {{$name}}</h2>

  <h1>Current Offerings</h1>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Year</th>
        <th>Trimester</th>
        <th>Course Code</th>
        <th>Course Name</th>
      </tr>
    </thead>
    <tbody>

      @forelse($offerings as $offering)
        <tr>
          <td>{{$offering->Year}}</td>
          <td>{{$offering->Term}}</td>
          <td>{{$offering->Course_Code}}</td>
          <td>{{$offering->Course_Name}}</td>
        </tr>
      @empty
        <tr>
            <td colspan="4" style="text-align: center;">No assigned offerings</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>




<div>

  <h1>Functions</h1>
      <ul>

      </ul>
      <hr>
      <h6>View Courses Dashboard:</h6>
      <form method="post" action="{{url("dash")}}">
            {{csrf_field()}}
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">  Enter year</label>
              <div class="col-sm-10">
                <input type="text" name="year" class="form-control" >
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Trimester</label>
                <div class="col-sm-10">
                <select name="trimester" class="form-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
                </div>
            </div>
            <button type="submit" class="btn btn-outline-success"><i class="fa-regular fa-circle-check"></i> Submit</button>
      </form>
      <hr>
      <h6>View Academics Dashboard:</h6>
      <form method="post" action="{{url("dash/academics")}}">
            {{csrf_field()}}
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">  Enter year</label>
              <div class="col-sm-10">
                <input type="text" name="year" class="form-control" >
              </div>
            </div>

            <button type="submit" class="btn btn-outline-success">
                <i class="fa-regular fa-circle-check"></i> Submit
            </button>

      </form>
      <hr>
      <h6>Copy offering (roll over)</h6>
      <form method="post" action="{{url("offering_copy")}}">
        {{csrf_field()}}
        <label>  From year</label>
        <div class="col-sm-10">
          <input type="text" name="from_year" class="form-control" >
        </div>
        <label class="col-sm-2 col-form-label">  To year</label>
        <div class="col-sm-10">
          <input type="text" name="to_year" class="form-control" >
        </div>
        <br>
        <button type="submit" class="btn btn-outline-success"><i class="fa-regular fa-circle-check"></i> Submit</button>
      </form>
</div>

@endsection
