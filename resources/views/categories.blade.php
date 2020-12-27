@extends('master')
@section('content')
    <div class="starter-template">
        @foreach($categories as $cat)
            <div class="panel">
                <a href="{{$cat->code}}">
                    <img src="http://internet-shop.tmweb.ru/storage/categories/{{$cat->image}}">
                    <h2>{{$cat->name}}</h2>
                </a>
                <p>
                    {{$cat->description}}
                </p>
            </div>
        @endforeach
    </div>
@endsection
