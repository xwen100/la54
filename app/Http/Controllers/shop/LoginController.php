<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

use App\Good;
use App\Member;
use App\Cart;

class LoginController extends Controller
{

	public function login()
	{
		$memberId = session('member_id');
		if($memberId)
		{
			return redirect('/shop/home');
		}else{
			return view('shop/login');
		}
	}

	public function act(Request $request)
	{
		$params = $request->all();

		$member = Member::where('username', $params['username'])
						->first();

		if(!$member->password) return back();
		if($member->password && (decrypt($member->password) == $params['password']))
		{
			session(['member_id'=>$member->id, 'member_name'=>$member->username]);
			$cart = Cookie::get('cart') ? unserialize(Cookie::get('cart')) : [];
			if($cart)
			{
				$memberId = session('member_id');
					$cart = collect($cart)->map(function($v, $k)use($memberId){
					$v['member_id'] = $memberId;
					return $v;
				})->toArray();
	 			Cart::insert($cart);
	 			$cookie = Cookie::forget('cart');
				return redirect('/shop/home')->withCookie($cookie);
			}
		}
		return redirect('/shop/home');
	}


	public function logout(Request $request)
	{
		$request->session()->flush();
		return redirect('/shop/home');
	}

}