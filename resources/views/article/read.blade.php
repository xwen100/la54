@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10">
        	<div class="articl-wrap">
			    <h2>{{$data['title']}}</h2>
			    <p class="p1">作者： {{$data['username']}} • {{$data['created_at']}} </p>
			    <div class="d1">
			    	{!!$data['content']!!}
			    </div>
			    <hr>
			    <p class="p3">
			        <span class="glyphicon glyphicon-tag"></span>{{$data['name']}}
			    </p>
			</div>
        </div>
        <div class="col-md-2">
            @include('right')
        </div>
    </div>
</div>

@endsection