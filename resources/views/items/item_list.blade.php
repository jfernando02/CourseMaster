@extends('layouts.master')

@section('title')
  Item list
@endsection
 
@section('content')
<h1>Items</h1>
  @if ($items)
    <ul>
    @foreach($items as $item)
      <li><a href="{{url("item_detail/$item->id")}}">{{$item->summary}}</a></li>
    @endforeach
    </ul>
  @else
    No item found
  @endif  
@endsection
