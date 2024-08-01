<!DOCTYPE html>
<html>
<head>
  <title>@yield('title')</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="{{asset('css/wp.css')}}">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<body>

  @yield('content')
</body>
</html>