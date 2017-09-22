<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\User;
use App\Cat;
use App\Article;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $catList = Cat::where('user_id', Auth::user()->admin_id)->get()->toArray();
        $param = request()->all();
        $catId = array_key_exists('cat', $param) ? $param['cat'] : 0;
        $where = [
            'a.user_id' => Auth::user()->admin_id
        ];
        if($catId > 0)
        {
            $where['cat_id'] = $catId;
        }
        $list = Article::from('articles as a')
                ->leftJoin('cats as c', 'a.cat_id', '=', 'c.id')
                ->leftJoin('users as u', 'a.user_id', '=', 'u.admin_id')
                ->select(['a.title', 'a.id', 'u.name as username', 'a.created_at', 'a.desc', 'c.name'])
                ->where($where)
                ->orderBy('id', 'desc')
                ->get()->toArray();
        return view('home', ['catList'=>$catList, 'list'=>$list]);
    }
}
