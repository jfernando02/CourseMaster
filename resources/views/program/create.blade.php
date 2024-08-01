@extends('layouts.master')

@section('title')
  Add Program
@endsection



@section('content')
  <h1>Add Program</h1>
  @if (count($errors) > 0)
    <div class="alert">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="post" action="{{url("program")}}">
    {{csrf_field()}}
    <div class="form-group">
      <label>Short Name e.g. BIT (required)</label>
      <input type="text" name="name" class="form-control" value="{{old('name')}}" required >
    </div>
    <div class="form-group">
      <label>Full Name</label>
      <input type="text" class="form-control" name="fullname" value="{{old('fullname')}}">
    </div>  

    <div class="form-group">
      <label>Code</label>
      <input type="text" class="form-control" name="code" value="{{old('code')}}">
    </div>

    <div class="form-group">
      <label>Note</label>
      <textarea type="text" class="form-control" name="note" value="{{old('note')}}"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>

  </form>
@endsection