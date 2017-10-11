<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

use App\Member;

class RegisterController extends Controller
{
	public function reg()
	{
		$memberId = session('member_id');
		if($memberId)
		{

		}else{
			return view('shop/reg');
		}
	}
	public function save(Request $request)
	{
		$params = $request->all();

		$this->validate($request, [
				'username' => 'required|unique:members|max:255',
				'phone' => 'required|unique:members|regex:/^\d{11}$/',
				'password' => 'required|same:password1|min:6',
			],[
				'username.required' => '用户名必填',
				'username.unique' => '用户名必须唯一',
				'username.max' => '用户名过长',
				'phone.regex' => '手机号格式不对',
				'password.same' => '两次密码不相同',
				'password.min' => '密码至少六位'
			]);

		$member = new Member();
		$member->username = $params['username'];
		$member->phone = $params['phone'];
		$member->password = encrypt($params['password']);
		$member->save();
		//session(['member_id'=>$member->id]);
		return back();
	}
}