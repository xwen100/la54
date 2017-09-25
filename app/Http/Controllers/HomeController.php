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
        $catList = $this->getCat();
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
                ->simplePaginate(3)->toArray();
        if($catId > 0)
        {
            if($list['next_page_url'] !== null)
            {
                $list['next_page_url'] .= '&cat='.$catId;
            }
            if($list['prev_page_url'] !== null)
            {
                $list['prev_page_url'] .= '&cat='.$catId;
            }
        }
        return view('home', ['catList'=>$catList, 'list'=>$list]);
    }

    private function getCat()
    {
        $list = Cat::where('user_id', Auth::user()->admin_id)->get()->toArray();
        return $list;
    }

    public function read($id)
    {
        $catList = $this->getCat();
        $data = Article::from('articles as a')
                ->leftJoin('cats as c', 'a.cat_id', '=', 'c.id')
                ->leftJoin('users as u', 'a.user_id', '=', 'u.admin_id')
                ->where('a.id', $id)
                ->where('a.user_id', Auth::user()->admin_id)
                ->first(['a.title', 'a.id', 'a.content', 'u.name as username', 'a.created_at', 'a.desc', 'c.name'])->toArray();
        $data['created_at'] = date('Y-m-d', strtotime($data['created_at']));

        return view('article/read', ['data'=>$data, 'catList'=>$catList]);
    }
}
