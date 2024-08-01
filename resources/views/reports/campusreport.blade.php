@extends('layouts.master')

@section('title')
    Report by Year and Trimester
@endsection

<style>
.table-fixed {
  table-layout: fixed;
}

.table-fixed th, .table-fixed td {
  width: 33.33%;
  word-wrap: break-word;
}
</style>

@section('content')
    @foreach ($years as $year)
        <h2>{{ $year }}</h2>
        @foreach ($trimesters as $trimester)
        @if($offerings->where('year', $year)->where('trimester', $trimester)->count() > 0)
        <h4>Trimester {{ $trimester }}</h4>
        <table class="table table-striped table-bordered table-fixed">
            <thead>
                <tr>
                    {{-- <th>Year</th>
                    <th>Term</th> --}}
                    <th>Campus</th>
                    <th>Course Name</th>
                    <th>Academic Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($offerings->where('year', $year)->where('trimester', $trimester) as $offering)
                    <tr>
                        {{-- <td>{{ $offering->year }}</td>
                        <td>{{ $offering->trimester }}</td> --}}
                        <td>{{ $offering->campus }}</td>
                        <td>{{ $offering->Course->name }}</td>
                        <td>{{ $offering->Academic->firstname }} {{ $offering->Academic->lastname }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    @endforeach
    @endforeach
@endsection
