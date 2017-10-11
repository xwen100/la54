@extends('layouts.shop')

@section('content')

<div class="container">
	<table class="table">
		<thead>
			<tr>
				<th>编号</th>
				<th>名称</th>
				<th>图片</th>
				<th>数量</th>
				<th>操作</th>
			</tr>
		</thead>
		<tbody>
			@foreach($cart as $k => $v)
			<tr>
				<td>{{$v['sn']}}</td>
				<td>{{$v['name']}}</td>
				<td><img src="{{$v['logo']}}" width="50"></td>
				<td>
					<!--<input id="{{$v['id']}}" class="form-control initialized" style="width: 50px; text-align: center;" name="num" value="{{$v['num']}}" type="text">-->
					{{$v['num']}}
				</td>
				<td><a href="/shop/cart/{{$v['id']}}">删除</a></td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<div class="row cart-btn">
		<a href="/shop/home" class="btn btn-warning" style="margin-right: 5px;">继续购物</a>
		<a href="/shop/order" class="btn btn-info">去结算</a>
	</div>
</div>

@endsection
