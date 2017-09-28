@extends('layouts.app')

@section('content')

<div class="container">
	<div class="image-wrap">
		<h2>相册</h2>
		<hr>
		<div class="row">
		@foreach($list as $k => $v)
		  <div class="col-xs-6 col-md-3">
		  	@if($v['cover_url'] != '')
		    <a href="/image/{{$v['id']}}" class="thumbnail">
		      <img src="/album/get/{{$v['id']}}" width="300">
		    </a>
		    @else
		    <a href="/image/{{$v['id']}}" class="thumbnail">
		    	<img src="/images/0.jpg" width="300">
		    </a>
		    @endif
		    <div class="caption">
		      <h3>{{$v['name']}}</h3>
		      <p>{{$v['image_num']}}张</p>
		    </div>
		  </div>
		@endforeach
		  </div>

	</div>
</div>

@endsection