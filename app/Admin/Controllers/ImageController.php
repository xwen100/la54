<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Grid;
use Encore\Admin\Form;

use Encore\Admin\Widgets\Box;
use Encore\Admin\Layout\Row;

use App\Image;
use App\Album;


class ImageController extends Controller
{
    use ModelForm;

    public function index($albumId)
    {
        return Admin::content(function(Content $content) use ($albumId){
            $content->header('照片列表');
            $content->row('<a href="/admin/image/'.$albumId.'/create" class="btn btn-primary" style="margin-bottom:10px; float: right;">添加照片</a>');
            $imageList = Image::where('album_id', $albumId)
                            ->where('user_id', Admin::user()->id)
                            ->orderBy('id', 'desc')
                            ->get()->toArray();
            $content->row(function(Row $row) use ($albumId, $imageList) {
                collect($imageList)->map(function($v, $k) use ($albumId, $row){
                    $show = $v['show'] == 1 ? '显示' : '不显示';
                    $content = '<p><img src="/admin/image/get/'.$v['id'].'" width="300"></p>';
                    $content .= '<p>'. $show .'</p>';
                    $content .= '<p style="text-align:right;">';
                    if($v['is_cover'] == 1)
                    $content .= '<span style="padding-right:3px;">已为封面</span>';
                    else
                    $content .= '<a style="padding-right:10px;" href="/admin/image/'.$v['id'].'/set">设为封面</a>';

                    $content .= '<a style="padding-right:10px;" href="/admin/image/'.$v['id'].'/edit"><i class="fa fa-edit"></i></a><a style="padding-right:10px;" href="/admin/image/destroy/'.$v['id'].'"><i class="fa fa-trash"></i></a></p>';
                    $box = new Box($v['name'], $content);
                    $row->column(4, $box);
                });
            });
            
        });
    }

    public function create($albumId)
    {
        return Admin::content(function(Content $content) use ($albumId) {
    		$content->header('添加照片');
    		$content->body($this->form($albumId));
    	});
    }

    private function form($albumId)
    {
    	return Admin::form(Image::class, function(Form $form) use ($albumId)  {
    		$form->setAction('/admin/image/save');
    		$albumData = Album::where('id', $albumId)->first()->toArray();
    		$form->hidden('album_id')->value($albumData['id']);
    		$albumData = Album::where('id', $albumId)->first()->toArray();
    		$form->html('<span style="padding-top:5px;display:inline-block;">'.$albumData['name'].'</span>', '所属相册');
            //$form->multipleImage('url', '上传照片')->uniqueName();
    		$form->image('url', '上传照片')->uniqueName();
            $states = [
                        'on'=>['value'=>'1', 'text'=>'显示', 'color'=>'success'],
                        'off'=>['value'=>'0', 'text'=>'不显示', 'color'=>'danger']
                      ];
            $form->switch('show', '是否显示')->states($states)->default('1');
    	});
    }

    public function save()
    {
    	$params = request()->all();
    	$albumId = $params['album_id'];
        $show = $params['show'] == 'on' ? '1' : '0';
        /*foreach($_FILES['url']['tmp_name'] as $k => $v)
		{
			if($v && ($_FILES['url']['type'][$k] == 'image/jpeg'))
            {
                $filename = uploadImage($v);
                $name = explode('/', $filename);
                $name = array_pop($name);
                $image = new Image();
                $image->url = $filename;
                $image->name = $name;
                $image->album_id = $albumId;
                $image->user_id = Admin::user()->id;
                $image->show = $show;
                $image->save();
                $album = Album::find($albumId);
                $album->image_num = $album->image_num + 1;
                $album->save();
            }
		}*/
        if($_FILES['url']['tmp_name'] && ($_FILES['url']['type'] == 'image/jpeg')){
            $filename = uploadImage($_FILES['url']['tmp_name']);
            $name = explode('/', $filename);
            $name = array_pop($name);
            $image = new Image();
            $image->url = $filename;
            $image->name = $name;
            $image->album_id = $albumId;
            $image->user_id = Admin::user()->id;
            $image->show = $show;
            $image->save();
            $album = Album::find($albumId);
            $album->image_num = $album->image_num + 1;
            $album->save();
        }
        return redirect('/admin/image/'.$albumId);
    }

    public function getImage($id)
    {

        $url = Image::where('id', $id)->value('url');
        readImage(public_path().$url);
    }

    public function edit($id)
    {
        return Admin::content(function(Content $content) use ($id){
            $content->header('编辑照片');
            $content->body($this->editForm($id));
        });
    }

    private function editForm($id)
    {
        return Admin::form(Image::class, function(Form $form) use ($id){
            $form->setAction('/admin/image/update/'.$id);
            $imageData = Image::from('images as i')
                    ->leftJoin('albums as a', 'a.id', '=', 'i.album_id')
                    ->where('i.id', $id)
                    ->select('i.*', 'a.name as albumName', 'a.id as albumId')
                    ->first();
            $form->html('<span style="padding-top:5px;display:inline-block;">'.$imageData['albumName'].'</span>', '所属相册');
            $form->hidden('album_id')->value($imageData['albumId']);
            $htmlStr = '<img src="/admin/image/get/'.$id.'" width="300">';
            $form->html($htmlStr, '照片');
            $states = [
                        'on'=>['value'=>'1', 'text'=>'显示', 'color'=>'success'],
                        'off'=>['value'=>'0', 'text'=>'不显示', 'color'=>'danger']
                      ];
            $form->switch('show', '是否显示')->states($states)->default($imageData['show']);
            $form->display('name', '名称')->value($imageData['name']);
        });
    }

    public function update($id)
    {
        $param = request()->all();
        $show = $param['show'] == 'on' ? '1' : '0';
        $image = Image::find($id);
        $image->show = $show;
        $image->save();
        return redirect('/admin/image/'.$param['album_id']);
    }

    public function destroy($id)
    {
        $image = Image::find($id);
        if($image)
        {
            $url = public_path() . $image->url;
            $image->delete();
            unlink($url);
            $album = Album::find($image->album_id);
            $album->image_num = $album->image_num - 1;
            $album->save();
        }
        return redirect('/admin/image/'.$image->album_id);
    }

    public function set($id)
    {
        $image = Image::find($id);
        $album = Album::where('id', $image->album_id)->first();
        $album->cover_url = $image->url;
        $album->save();
        Image::where('id', '<>', $id)
            ->where('album_id', $image->album_id)
            ->update(['is_cover'=>0]);
        $image->is_cover = 1;
        $image->save();
        return redirect('/admin/image/'.$image->album_id);
    }

}