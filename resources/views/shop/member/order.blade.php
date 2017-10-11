@extends('layouts.shop')

@section('content')

<div class="container">
	<div class="row">
        <div class="col-md-2">
            @include('shop/member/right')
        </div>
        <div class="col-md-10">
        <h3>订单信息</h3>
        <table class="table">
        	<thead>
        		<tr>
        			<th>订单号</th>
        			<th>支付状态</th>
        			<th>发货状态</th>
        			<th>总价格</th>
        			<th>支付方式</th>
        			<th>下单时间</th>
        		</tr>
        	</thead>
        	<tbody>
        		@foreach($list as $k => $v)
        		<tr style="background: #FFF;">
        			<td>{{$v[0]->sn}}</td>
        			<td>
        				@if($v[0]->pay_status == 0)
					        未支付
					    @elseif($v[0]->pay_status == 1)
					    	已支付
					    @else
					    	未支付
					    @endif

        			</td>
        			<td>
        				@if($v[0]->post_status == 0)
					        未发货
					    @elseif($v[0]->post_status == 1)
					    	已发货
					    @else
					    	未发货
					    @endif

        			</td>
        			<td>{{$v[0]->total_price}}</td>
        			<td>
        				@if($v[0]->pay_method == 1)
					        支付宝
					    @elseif($v[0]->pay_method == 2)
					    	微信
					    @else
					    	支付宝
					    @endif
        			</td>
        			<td>{{$v[0]->addtime}}</td>
        		</tr>
        		<tr class="consignee-info">
        			<td colspan="6">
        				<h3>收货人信息</h3>
        				<dl>
        					<dt>姓名：</dt>
        					<dd>{{$v[0]->username}}</dd>
        				</dl>
        				<dl>
        					<dt>电话：</dt>
        					<dd>{{$v[0]->phone}}</dd>
        				</dl>
        				<dl>
        					<dt>地址：</dt>
        					<dd>{{$v[0]->address}}</dd>
        				</dl>
        				<h3>货物信息</h3>
        				<table class="table">
        					<thead>
				        		<tr>
				        			<th>图片</th>
				        			<th>名称</th>
				        			<th>价钱</th>
				        			<th>数量</th>
				        		</tr>
				        	</thead>
				        	<tbody>
				        		@foreach($v as $k1 => $v1)
				        		<tr>
				        			<td><img src="{{$v1->goods_logo}}" width="50" /></td>
				        			<td>{{$v1->goods_name}}</td>
				        			<td>{{$v1->goods_price}}</td>
				        			<td>{{$v1->goods_num}}</td>
				        		</tr>
				        		@endforeach
				        	</tbody>
        				</table>
        			</td>
        		</tr>
        		@endforeach
        	</tbody>
        </table>
        </div>
    </div>
</div>

@endsection