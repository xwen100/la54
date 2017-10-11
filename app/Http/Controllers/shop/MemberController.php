<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;

use DB;

class MemberController extends Controller
{

	public function index()
	{
		return view('shop/member/index');
	}

	public function order()
	{
		$memberId = session('member_id');
		if(!$memberId)
			return redirect('/shop/home');
		$list = DB::table('orders as o')
				->leftJoin('order_goods as og', 'o.id', '=', 'og.order_id')
				->where('o.member_id', $memberId)
				->get(['o.*', 'og.goods_id', 'og.goods_logo', 'og.goods_name', 'og.goods_price', 'og.goods_num'])->toArray();
		$list = collect($list)->groupBy('id')->values()->toArray();
		return view('shop/member/order', ['list'=>$list]);
	}

}