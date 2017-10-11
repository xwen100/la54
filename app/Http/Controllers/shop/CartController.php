<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

use App\Good;
use App\Cart;

class CartController extends Controller
{
	public function save(Request $request)
	{
		$param = $request->all();
		$memberId = session('member_id');
		if($memberId)
		{
			$cart = Cart::where('member_id', $memberId)
						->where('goods_id', $param['id'])
						->first();
			if($cart !== null)
			{
				$cart->goods_num = $cart->goods_num + $param['num']; 
				$cart->save();
			}else{
				$cart = [
						'goods_id' => $param['id'],
						'goods_num' => $param['num'],
						'member_id' => $memberId
					];
 				Cart::insert($cart);
			}
			return redirect('/shop/cart');
		}else{
			$cart = Cookie::get('cart') ? unserialize(Cookie::get('cart')) : [];
			$has = false;
			foreach($cart as $k => $v)
			{
				if($v['goods_id'] == $param['id'])
				{
					$has = true;
					$cart[$k]['goods_num'] += $param['num'];
					break;
				}
			}
			if(!$has)
			{
				$cart[] = [
							'goods_id' => $param['id'],
							'goods_num' => $param['num']
						];
			}
			$cookie = Cookie::forever('cart', serialize($cart));
			return redirect('/shop/cart')->withCookie($cookie);
		}
	}

	public function index()
	{
		$memberId = session('member_id');
		if($memberId)
		{
			$cart = Cart::where('member_id', $memberId)->get()->toArray();
		}else{
			$cart = Cookie::get('cart') ? unserialize(Cookie::get('cart')) : [];
		}
		$cart = collect($cart)->map(function($v, $k){
			$goods = Good::find($v['goods_id']);
			return [
				'sn' => $goods->sn,
				'name' => $goods->name,
				'logo' => $goods->logo,
				'num' => $v['goods_num'],
				'id' => $goods->id
			];
		})->toArray();
		return view('shop/cart/index', ['cart'=>$cart]);
	}

	public function delete($id)
	{
		$memberId = session('member_id');
		if($memberId)
		{
			Cart::where('member_id', $memberId)
				->where('goods_id', $id)
				->delete();
			return redirect('/shop/cart');
		}else{
			$cart = Cookie::get('cart') ? unserialize(Cookie::get('cart')) : [];
			$cart = collect($cart)->reject(function($v, $k)use($id){
				return $v['goods_id'] == $id;
			})->values()->toArray();
			$cookie = Cookie::forever('cart', serialize($cart));
			return redirect('/shop/cart')->withCookie($cookie);
		}
	}

	public function update($id)
	{
		$cart = Cookie::get('cart') ? unserialize(Cookie::get('cart')) : [];
		$cart = collect($cart)->map(function($v, $k)use($id){
			if($v['goods_id'] == $id)
			{
				$v['num'] = request()->input('num');
			}
			return $v;
		})->toArray();
		$cookie = Cookie::forever('cart', serialize($cart));
		return redirect('/shop/cart')->withCookie($cookie);
	}

}