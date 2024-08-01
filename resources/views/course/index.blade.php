@extends('layouts.master')

@section('title')
    Course list
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
    <a class="btn btn-outline-primary" href="{{ url('course/create') }}"><i class="fa-regular fa-plus"></i> Add a new
        course</a>
    <h1>Courses</h1>

    <a class="btn btn-outline-primary" href="{{ url('course/1/edit') }}"><i class="fa-regular fa-pen-to-square"></i> Edit</a>
    <div class="row mt-3">
        {{-- <a class="btn btn-warning" href="{{ url('course/1/edit') }}">Edit</a> --}}
        <div class="col-4">
            <form action="{{ route('course.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <div class="input-group">
                        <input type="file" id = "fileInput" name="file" class="form-control">
                        <button class="btn btn-outline-primary" id="uploadButton" disabled><i class="fas fa-upload"></i>Upload Excel File</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-2">
            <a class="btn btn-outline-success" href="{{ url('course/export/1') }}"><i class="fas fa-download"></i>Download
                Excel File</a>
        </div>
    </div>
    <table class="table" id="coursesTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Name</th>
                <th>Prerequisite</th>
                <th>Transition</th>
                <th>Teaching Method</th>
                <th>Note</th>
            </tr>
            <tr>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search ID" data-column="0">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search Code" data-column="1">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search Name" data-column="2">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search Prerequisite" data-column="3">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search Transition" data-column="4">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search Teaching Method" data-column="5">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search Note" data-column="6">
                </td>
            </tr>
        </thead>
        <tbody>
            @foreach ($courses as $course)
                <tr>
                    <td>{{ $course->id }}</td>
                    <td>{{ $course->code }}</td>
                    <td><a href="{{ url("course/$course->id") }}">{{ $course->name }}</a></td>
                    <td>{{ $course->prereq }}</td>
                    <td>{{ $course->transition }}</td>
                    <td>{{ $course->tmethod }}</td>
                    <td>{{ $course->note }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script src="{{ asset('js/table-filter.js') }}"></script>
    @endsection
