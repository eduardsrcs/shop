@extends('layouts/master', ['tile' => 'cats'])
@section('title', 'Все категории')
@section('content')
    @foreach($categories as $cat)
        <div class="panel">
            <!-- <a href="/categories/{{$cat->code}}"> -->
            <a href="{{ route('category', $cat->code)}}">
                <img src="http://internet-shop.tmweb.ru/storage/categories/{{$cat->image}}">
                <h2>{{$cat->name}}</h2>
            </a>
            <p>
                {{$cat->description}}
            </p>
        </div>
    @endforeach
@endsection
