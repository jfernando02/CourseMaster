@extends('layouts.master')

@section('title')
  Home
@endsection




@section('content')

    <html>
    <head>
        <title>Coursemaster</title>
    </head>
    <body>
    <h1>Welcome {{$name}}</h1>
    <header>
        <h1>View
            <select id="menu1">
                <!-- Dynamically generate options -->
                @foreach($menu1Options as $option)
                    <option value="{{$option}}">{{$option}}</option>
                @endforeach
            </select>
            assigned to you for trimester
            <select id="menu2">
                <!-- Dynamically generate options -->
                @foreach($menu2Options as $option)
                    <option value="{{$option}}">{{$option}}</option>
                @endforeach
            </select>
            year
            <select id="menu3">
                <!-- Dynamically generate options -->
                @foreach($menu3Options as $option)
                    <option value="{{$option}}">{{$option}}</option>
                @endforeach
            </select>
            <button id="submitButton">Submit</button>
        </h1>
    </header>
    <table class="table table-hover" id="data-table">
        <!-- Populated by JavaScript -->
    </table>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/axios@0.24.0/dist/axios.min.js"></script>
    <script>
        // Get references to HTML elements
        var menu1 = document.getElementById('menu1');
        var menu2 = document.getElementById('menu2');
        var menu3 = document.getElementById('menu3');
        var submitButton = document.getElementById('submitButton');

        // Add event listener to submit button
        submitButton.addEventListener('click', function() {

            var selectedOption1 = menu1.value;
            var selectedOption2 = menu2.value;
            var selectedOption3 = menu3.value;

            // map selectedOption1 to the API endpoint
            var endpoint;
            switch (selectedOption1) {
                case 'offerings':
                    endpoint = "/offeringsdashboard";
                    break;
                case 'classes':
                    endpoint = "/classesdashboard";
                    break;
                // add other cases if needed
                default:
                    console.log('Unknown option selected');
            }

            endpoint += '?year=' + selectedOption3 + '&trimester=' + selectedOption2;

            // Call the API endpoint using Axios
            axios.get(endpoint)
                .then(function (response) {
                    // handle the response data
                    var html = '';
                    if(selectedOption1==='classes') {
                        // Define Table Headers
                        html += `
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Class Type</th>
                                    <th>Campus</th>
                                    <th>Time Start</th>
                                    <th>Time End</th>
                                    <th>Day</th>
                                </tr>
                            </thead>
                            <tbody>
                        `;
                        response.data.forEach(function (item) {
                            html += '<tr>'
                            html += '<td>' + item.offering.course.code + ' ' + item.offering.course.name + '</td>'
                            html += '<td>' + item.class_type + '</td><td>' + item.offering.campus + '</td>';
                            html += '<td>' + item.start_time + '</td><td>' + item.end_time + '</td>';
                            html += '<td>' + item.class_day + '</td>';
                            html += '</tr>'
                        });
                        html += '</tbody></table>';
                    }
                    else if(selectedOption1==='offerings') {
                        // Define Table Headers
                        html += `
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Campus</th>
                                </tr>
                            </thead>
                            <tbody>
                        `;
                        response.data.forEach(function (item) {
                            if(item.course) {
                                html += '<tr>'
                                html += '<td>' + item.course.code + ' ' + item.course.name + '</td>';
                                html += '<td>' + item.campus + '</td>';
                                html += '</tr>'
                            }
                        });
                        html += '</tbody></table>';
                    }
                    document.getElementById('data-table').innerHTML = html;
                })
                .catch(function (error) {
                    console.log('Error fetching data: ', error);
                });
        });

    </script>
    </html>

@endsection
