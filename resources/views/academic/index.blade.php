@extends('layouts.master')

@section('title')
    Academics
@endsection

@section('content')
    @if (session('failures'))
        <div class="alert alert-danger">
            <ul>
                @foreach (session('failures') as $failure)
                    <li>Row {{ $failure->row() }}: {{ $failure->errors()[0] }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <a class="btn btn-outline-primary" href="{{ url('academic/create') }}"><i class="fa-regular fa-plus"></i> Add a new
        academic</a>
    <h1>Academics</h1>
    <!-- @if ($academics)
    <ul>
                            @foreach ($academics as $academic)
    <li><a href="{{ url("academic/$academic->id") }}">{{ $academic->lastname }}, {{ $academic->firstname }}</a></li>
    @endforeach
                            </ul>
@else
    No item found
    @endif -->

    <!-- add a button to edit -->
    <a class="btn btn-outline-primary" href="{{ url('academic/editbulk/1') }}"><i class="fa-regular fa-pen-to-square"></i>
        Edit
    </a>

    <div class="row mt-3">
        <div class="col-4">
            <form action="{{ route('academic.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <div class="input-group">
                        <input type="file" id = "fileInput" name="file" class="form-control">
                        <button class="btn btn-outline-primary" id="uploadButton" disabled><i class="fas fa-upload"></i>Upload Excel File</button>
                    </div>
                </div>

            </form>
        </div>
        <div class="col-4">
            <a class="btn btn-outline-primary" href="{{ url('academic/export/1') }}"><i class="fas fa-download"></i>Download
                Excel File</a>
        </div>
        <div class="col-4">
            <a class="btn btn-outline-primary" href="{{ url('academic/exportWorkload/1') }}"><i class="fas fa-download"></i>Download
                Academic Workloads</a>
        </div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Email</th>
                <th>Teaching Load (Current Trimester)</th>
                <th>Teaching Load (Current Year)</th>
                <th>Area</th>
                <th>Main Campus</th>
                <th>Note</th>
            </tr>
            <tr>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search Name" data-column="0">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search Email" data-column="1">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search Teaching Load"
                        data-column="2">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search Teaching Load (Year)"
                           data-column="3">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search Area" data-column="4">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search Main Campus"
                        data-column="5">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search Note" data-column="6">
                </td>
        </thead>
        <tbody>
            @foreach ($academics as $academic)
                <tr>
                    {{-- <td>{{$academic->id}}</td> --}}
                    <td><a href="{{ url("academic/$academic->id") }}">{{ $academic->lastname }},
                            {{ $academic->firstname }}</a></td>
                    {{-- <td><a href="{{url("academic/$academic->id")}}">{{$academic->firstname}} {{$academic->lastname}}, </a></td> --}}
                    <td>{{ $academic->email }}</td>
                    <td>{{ $academic->teachingHours($academic->id, 2024, 1) }} hours</td>
                    <td>{{ $academic->teachingHours($academic->id, 2024, 0) }} hours</td>
                    <td>{{ $academic->area }}</td>
                    <td>{{ $academic->home_campus }}</td>
                    <td>{{ $academic->note }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script src="{{ asset('js/table-filter.js') }}"></script>



@endsection
