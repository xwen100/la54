<?php

namespace App\Http\Controllers\shop;

use App\Http\Controllers\Controller;

use App\Good;

class HomeController extends Controller
{

	public function index()
	{
		$recList = Good::where('is_rec', 1)->get();
		$goodList = Good::from('goods as g')
					->leftJoin('goods_cats as c', 'g.cat_id', '=', 'c.id')
					->select('c.name as catName', 'c.id as cid', 'g.id', 'g.name', 'g.logo')
					->where('is_rec', '<>', 1)
					->get()->toArray();
		$goodsList = collect($goodList)->groupBy('cid')->toArray();
        return view('shop/home', ['recList'=>$recList, 'goodsList'=>$goodsList]);
		
	}

	public function read($id)
	{
		$good = Good::find($id)->toArray();
        return view('shop/goods/read', ['good'=>$good]);
	}

}
