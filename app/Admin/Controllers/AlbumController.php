<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Grid;
use Encore\Admin\Form;

use App\Album;

class AlbumController extends Controller
{
    use ModelForm;

    public function index()
    {
    	return Admin::content(function(Content $content){
    		$content->header('相册列表');
    		$content->body($this->grid());
    	});
    }

	private function grid()
	{
		return Admin::grid(Album::class, function(Grid $grid){
			$grid->disableExport();
			$grid->disableFilter();
			$grid->id('ID');
			$grid->name('名称');
			$grid->cover_url('封面')->value(function($v){
	            $filename = public_path().'/upload/'.$v;
	            $id = Album::where('cover_url', $v)->value('id');
				return '<img src="album/get/'.$id.'" class="img img-thumbnail" width="80" >';
			});
			$grid->image_num('照片数量');
			$grid->created_at('创建时间');
	        $grid->actions(function($actions){
	            $actions->append('<a href="'.url('/admin/image',['id'=>$actions->getkey()]).'"><i class="fa fa-file-image-o"></i></a>');
	        });
		});
	}

	public function create()
	{
		return Admin::content(function(Content $content){
			$content->header('添加相册');
			$content->body($this->form());
		});
	}

	private function form()
    {
    	return Admin::form(Album::class, function(Form $form){
    		$form->text('name', '名称');
    		$form->image('cover_url', '封面');
            $userId = Admin::user()->id;
            $form->hidden('user_id')->value($userId);
    	});
    }

    public function getAlbumImage($id)
    {

        $coverUrl = Album::where('id', $id)->value('cover_url');
        $filename = public_path().'/upload/'.$coverUrl;
        readImage($filename);
    }


}


?>