@extends('layouts.shop')

@section('content')

<div class="container">
	<div class="image-wrap">
		<h2>推荐商品</h2>
		<hr>
		<div class="row">
		@foreach($recList as $k => $v)
		  <div class="col-xs-6 col-md-3">
		    <a href="/shop/home/read/{{$v['id']}}" class="thumbnail">
		      <img src="{{$v['logo']}}" width="500">
		    </a>
		    <div class="caption">
		      <h3>{{$v['name']}}</h3>
		    </div>
		  </div>
		@endforeach
		</div>
	</div>
	@foreach($goodsList as $k => $v)
	<div class="image-wrap">
		<h2>{{$v[0]['catName']}}</h2>
		<hr>
		<div class="row">
		@foreach($v as $k1 => $v1)
		  <div class="col-xs-6 col-md-3">
		    <a href="/shop/home/read/{{$v1['id']}}" class="thumbnail">
		      <img src="{{$v1['logo']}}" width="500">
		    </a>
		    <div class="caption">
		      <h3>{{$v1['name']}}</h3>
		    </div>
		  </div>
		@endforeach
		</div>
	</div>
	@endforeach
</div>

@endsection