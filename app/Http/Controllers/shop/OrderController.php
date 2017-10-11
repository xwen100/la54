<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

use App\Good;
use App\Cart;
use App\Address;
use App\Order;
use App\OrderGoods;

class OrderController extends Controller
{
	public function add()
	{
		$memberId = session('member_id');
		if($memberId)
		{
			return redirect('/shop/order/act');
		}else{
			return redirect('/shop/login');
		}
	}

	public function pay()
	{
		dd('pay');
	}

	public function act()
	{
		$memberId = session('member_id');
		if($memberId)
		{
			$carts = Cart::where('member_id', $memberId)->get()->toArray();
			$total = 0;
			$carts = collect($carts)->map(function($v, $k) use (&$total){
				$good = Good::find($v['goods_id']);
				$total += $good->price * $v['goods_num'];
				return [
					'sn' => $good->sn,
					'name' => $good->name,
					'logo' => $good->logo,
					'price' => $good->price,
					'num' => $v['goods_num'],
				];
			})->toArray();
			$address = Address::where('member_id', $memberId)->get()->toArray();
			return view('/shop/order/act', ['carts'=>$carts, 'total'=>$total, 'address'=>$address]);
		}
		return redirect('/shop/home');

	}

	public function ord1(Request $request)
	{
		$params = $request->all();
		$memberId = session('member_id');
		if($memberId)
		{
			$orderData = [];
			$order = new Order();
			if($params['address'])
			{
				$address = new Address();
				$address->username = $params['username'];
				$address->phone = $params['phone'];
				$address->address = $params['address'];
				$address->member_id = $memberId;
				$address->save();
				$order->username = $address->username;
				$order->phone = $address->phone;
				$order->address = $address->address;
			}else{
				$address = Address::find($params['address_id']);
				$order->username = $address->username;
				$order->phone = $address->phone;
				$order->address = $address->address;
			}
			$order->pay_method = $params['pay_method'];
			$total_price = 0;
			$carts = Cart::where('member_id', $memberId)->get()->toArray();
			$orderGoods = [];
			$carts = collect($carts)->map(function($v, $k) use (&$total_price, &$orderGoods){
				$good = Good::find($v['goods_id']);
				$orderGoods[$k]['goods_id'] = $good->id;
				$orderGoods[$k]['goods_logo'] = $good->logo;
				$orderGoods[$k]['goods_name'] = $good->name;
				$orderGoods[$k]['goods_price'] = $good->price;
				$orderGoods[$k]['goods_num'] = $v['goods_num'];
				$total_price += $good->price * $v['goods_num'];
			})->toArray();
			$order->total_price = $total_price;
			$order->member_id = $memberId;
			$order->save();
			$order->sn = 'XWEN'. $order->id .time();
			$order->save();
			$orderId = $order->id;
			$orderGoods = collect($orderGoods)->map(function($v, $k) use ($orderId){
				$v['order_id'] = $orderId;
				return $v;
			})->toArray();
			OrderGoods::insert($orderGoods);
			Cart::where('member_id', $memberId)->delete();
			return redirect('/shop/pay');
		}
			return redirect('/shop/login');
	}

}