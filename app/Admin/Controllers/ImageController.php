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
    		$form->multipleImage('url', '上传照片')->uniqueName();
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
        $image = new Image();
        foreach($_FILES['url']['tmp_name'] as $k => $v)
		{
			if($v && ($_FILES['url']['type'][$k] == 'image/jpeg'))
            {
                $filename = uploadImage($v);
                $name = explode('/', $filename);
                $name = array_pop($name);
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
		}
        return redirect('/admin/album/'.$albumId.'/images');
    }

    public function getImage($id)
    {

        $url = Image::where('id', $id)->value('url');
        readImage($url);
    }

}