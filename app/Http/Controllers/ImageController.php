<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Image;
use App\Album;

class ImageController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function get($id)
    {
        $url = Image::where('id', $id)->value('url');
        $filename = public_path() . $url;
        readImage($filename);
    }

    public function index($albumId)
    {
        $albumName = Album::where('id', $albumId)->value('name');
        $list = Image::where('user_id', Auth::user()->admin_id)
                    ->where('album_id', $albumId)
                    ->get()->toArray();
        return view('image/index', ['list'=>$list, 'albumName'=>$albumName]);    
    }
    	
}