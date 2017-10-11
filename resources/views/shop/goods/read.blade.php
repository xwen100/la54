@extends('layouts.shop')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-6 read-left">
			<img src="{{$good['logo']}}" width="500" class="img-rounded">
		</div>
		<div class="col-md-4 read-right">
			<h2>{{$good['name']}}</h2>
			<dl>
				<dt>价格：</dt>
				<dd class="price">¥{{$good['price']}}元/斤</dd>
			</dl>
			<form class="form-inline" action="/shop/cart" method="post">
				{{ csrf_field() }}
				<div class="form-group">
					<label >数量：</label >
					<input type="text" name="num" class="form-control" value="1">
					<input type="hidden" name="id" value="{{$good['id']}}">
					<span>斤</span>
				</div>
				<p class="add-btn">
				<button class="btn btn-primary" type="submit">
					<span class="glyphicon glyphicon-shopping-cart icon"></span>加入购物车
				</button></p>
			</form>
		</div>
	</div>
	<div class="row">
		<h3>描述</h3>
		<div class="desc-wrap">{{$good['desc']}}</div>
	</div>
</div>

@endsection
