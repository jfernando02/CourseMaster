@extends('layouts.master')

@section('title')
    Offerings
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

    <h1>Offerings</h1>
    <a class="btn btn-outline-primary" href="{{ url('offering/create') }}"><i class="fa-regular fa-plus"></i> Create Trimester
        Offerings</a>

    {{-- button for edit bulk --}}

    <div class="row mt-3">
        <div class="col-4">
            <form action="{{ url('offering/import/1') }}" method="POST" enctype="multipart/form-data">
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
            <a class="btn btn-outline-primary" href="{{ url('offering/export/1') }}"><i class="fas fa-download"></i>Download
                Excel File</a>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Course</th>
                <th>Year</th>
                <th>Trimester</th>
                <th>Campus</th>
                <th>Convenors</th>
                <th>Notes</th>
            </tr>
            <tr>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search ID" data-column="0">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search Course" data-column="1">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search Year" data-column="2">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search Trimester" data-column="3">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search Campus" data-column="4">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search Convenor" data-column="5">
                </td>
                <td>
                    <input type="text" class="form-control filter-input" placeholder="Search Notes" data-column="6">
                </td>
        </thead>
        <tbody>
            @foreach ($offerings as $offering)
                <tr>
                    <td>{{ $offering->id }}</td>
                    <td><a href='{{ url("offering/{$offering->id}") }}'>{{ $offering->course->code }}
                            {{ $offering->course->name }}</a></td>
                    <td>{{ $offering->year }}</td>
                    <td>{{ $offering->trimester }}</td>
                    <td>{{ $offering->campus }}</td>
                    <td>
                        @if (isset($offering->academics) && $offering->academics->count() > 0)
                            @foreach($offering->academics as $academic)
                            <a href='{{ url("academic/{$academic->id}") }}'>
                                {{ $academic->firstname }} {{ $academic->lastname }}</a>
                            @endforeach
                        @else
                            Unassigned
                        @endif
                    </td>
                    <td>
                        @if (isset($offering->note))
                            {{ $offering->note }}
                        @else
                            No notes
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
        <script src="{{ asset('js/table-filter.js') }}"></script>
    @endsection
