<?php

namespace App\Http\Controllers;

use App\Album;

use Illuminate\Support\Facades\Auth;

class AlbumController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $list = Album::where('user_id', Auth::user()->admin_id)->get()->toArray();
    	return view('album/index', ['list'=>$list]);
    }

    public function get($id)
    {
        $coverUrl = Album::where('id', $id)->value('cover_url');
        $filename = public_path() . $coverUrl;
        readImage($filename);
    }
    	
}