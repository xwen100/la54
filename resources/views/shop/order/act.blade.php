@extends('layouts.shop')

@section('content')

<div class="container">
	<div class="row">
		<form method="post" action="/shop/order/act">
            {{ csrf_field() }}
            <table class="table">
            	<thead>
            		<tr>
            			<th>姓名</th>
            			<th>电话</th>
            			<th>地址</th>
            			<th></th>
            		</tr>
            	</thead>
            	<tbody>
            		@foreach($address as $k => $v)
            		<tr>
            			<td>{{$v['username']}}</td>
            			<td>{{$v['phone']}}</td>
            			<td>{{$v['address']}}</td>
            			<td>
            				<input type="radio" value="{{$v['id']}}" name="address_id" @if($v['is_default'] == 1) checked @endif >
            			</td>
            		</tr>
            		@endforeach
            	</tbody>
            </table>
            <div class="row">
            	<button type="button" class="btn btn-default" id="addA">添加地址</button>
            </div>
			<div class="row" style="padding: 15px; display: none;" id="addrF">
				<div class="form-group">
				    <label>姓名</label>
				    <input type="text" name="username" class="form-control" placeholder="请输入姓名">
				</div>
				<div class="form-group">
				    <label>手机号</label>
				    <input type="text" name="phone" class="form-control" placeholder="请输入手机号">
				</div>
				<div class="form-group">
				    <label>地址</label>
				    <input type="text" name="address" class="form-control" placeholder="请输入地址">
				</div>
			</div>
			<table class="table">
				<thead>
					<tr>
						<th>图片</th>
						<th>编号</th>
						<th>名称</th>
						<th>价格</th>
						<th>数量</th>
					</tr>
				</thead>
				<tbody>
					@foreach($carts as $k => $v)
					<tr>
						<td><img src="{{$v['logo']}}" width="50" /></td>
						<td>{{$v['sn']}}</td>
						<td>{{$v['name']}}</td>
						<td>{{$v['price']}}</td>
						<td>{{$v['num']}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<div class="row" style="text-align: right; padding: 15px;">
				总价格：<span style="color: #F00; font-weight: bold; padding: 0 3px;">{{$total}}</span>元
			</div>
			<div class="row">
				支付宝 <input type="radio" name="pay_method" value="1" checked ><br>
				微信 <input type="radio" name="pay_method" value="2" > 
			</div>
			<div class="row">
				<button style="float: right;" class="btn btn-success">去结算</button>
			</div>
		</form>
	</div>

</div>

@endsection