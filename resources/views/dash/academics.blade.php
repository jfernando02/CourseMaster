@extends('layouts.master')

@section('title')
    Academics dashboard
@endsection
 
@section('content')
<h2>Academics dashboard for {{$year}}</h2>
<table class ="table">
  <thead>
    <tr>
      <th scope="col">Name</th>
      <th scope="col">Teaching %</th>
      <th scope="col">Load Count</th>
      <th scope="col">Number of Students</th>
      <th scope="col">T1</th>
      <th scope="col">T2</th>
      <th scope="col">T3</th>
    </tr>
  </thead>
  <tbody>
    @foreach($academics as $id => $academic)
      <tr>
        <td><a href="{{url("academic/{$academic['academic']->id}")}}">{{$academic['academic']->firstname}}, {{$academic['academic']->lastname}}</a></td>
        <td>{{$academic['academic']->teaching_load}}</td>
        <td>{{$academic['tcount']}}</td>
        <td>{{$academic['nstudents']}}</td>
        <td>
          @foreach ($academic['T1'] as $offering)
            <a href="{{url("offering/{$offering->id}")}}">{{$offering->course->code}}-{{$offering->campus}}</a> 
          @endforeach  
        </td>
        <td>
          @foreach ($academic['T2'] as $offering)
            <a href="{{url("offering/{$offering->id}")}}">{{$offering->course->code}}-{{$offering->campus}}</a> 
          @endforeach
      </td>
        <td>
          @foreach ($academic['T3'] as $offering)
            <a href="{{url("offering/{$offering->id}")}}">{{$offering->course->code}}-{{$offering->campus}}</a> 
          @endforeach
        </td>
      </tr>  
    @endforeach


    {{-- @foreach($academics_offerings as $id => $academic_offerings)
      <tr>
        <td><a href="{{url("academic/{$academic_offerings[0]->academic->id}")}}">{{$academic_offerings[0]->academic->lastname}}</a></td>
        <td>{{$academic_offerings[0]->academic->firstname}}</td>
        <td>{{$academic_offerings[0]->academic->teaching_load}}</td>
        <td>{{$tcounts[strval($id)]}}</td>
      </tr>
    @endforeach --}}
  </tbody>
</table>
@endsection