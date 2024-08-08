@extends('layouts.master')

@section('title')
  Add Academic
@endsection

@section('content')
  <h1>Add Academic</h1>
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

  <form method="post" action="{{url("academic")}}">
    {{csrf_field()}}
    <div class="form-group">
      <label>First Name (required)</label>
      <input type="text" name="firstname" class="form-control" value="{{old('firstname')}}" required >
    </div>
    <div class="form-group">
      <label>Last Name (required)</label>
      <input type="text" class="form-control" name="lastname" value="{{old('lastname')}}" required>
    </div>

      <div class="form-group">
          <label>Email (required) (NOTE: this cannot be changed after!)</label>
          <input type="email" class="form-control" name="email" value="{{old('email')}}" required>
      </div>

    <div class="form-group">
      <label>Teaching load</label>
      <input type="number" class="form-control" name="teaching_load" value="{{old('teaching_load')}}">
      <small class="form-text text-muted">E.g. enter 30 for 30%</small>
    </div>

    <div class="form-group">
      <label>Expertise Area</label>
      <textarea type="text" class="form-control" name="area" value="{{old('area')}}"></textarea>
    </div>

    <div class="form-group">
      <label>Note</label>
      <textarea type="text" class="form-control" name="note" value="{{old('note')}}"></textarea>
    </div>

    <button type="submit" class="btn btn-outline-success"><i class="fa-regular fa-circle-check"></i> Submit</button>

  </form>
@endsection
