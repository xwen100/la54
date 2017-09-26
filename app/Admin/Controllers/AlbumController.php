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
	            $id = Album::where('cover_url', $v)->value('id');
				return '<img src="album/get/'.$id.'?+" class="img img-thumbnail" width="80" >';
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
    		$form->setAction('/admin/album/save');
    		$form->text('name', '名称');
    		$form->image('cover_url', '封面');
    	});
    }

    public function getAlbumImage($id)
    {

        $coverUrl = Album::where('id', $id)->value('cover_url');
        $filename = public_path() . $coverUrl;
        readImage($filename);
    }

    public function save()
    {
    	$params = request()->all();
    	if($_FILES['cover_url']['tmp_name'] && ($_FILES['cover_url']['type'] == 'image/jpeg')){
    		$filename = uploadImage($_FILES['cover_url']['tmp_name']);
			$album = new Album();
			$album->user_id = Admin::user()->id;
			$album->name = $params['name'];
			$album->cover_url = $filename;
			$album->save();
    	}
    	return redirect('/admin/album');
    }

    public function edit($id)
    {
        return Admin::content(function(Content $content) use ($id){
            $content->header('编辑相册');
            $content->body($this->editForm()->edit($id));
        });
    }

    private function editForm()
    {
    	return Admin::form(Album::class, function(Form $form){
    				$form->setAction('/admin/album/update');
		    		$form->text('name', '名称');
		    		$id = 0;
		    		$form->display('cover_url', '封面')->with(function($v)use(&$id){
		    			$id = Album::where('cover_url', $v)->value('id');
						return '<img src="/admin/album/get/'.$id.'?+" class="img img-thumbnail" width="200" >';
		    		});
    				$form->image('n_cover_url', '新封面');
    				$form->hidden('cover_url')->value($form->cover_url);
    				$form->hidden('id')->value($id);
		    	});
    }

    public function update()
    {
    	$params = request()->all();
		$album = Album::where('id', $params['id'])->first();
		$album->name = $params['name'];
    	if($_FILES['n_cover_url']['tmp_name'] && ($_FILES['n_cover_url']['type'] == 'image/jpeg')){
    		$filename = uploadImage($_FILES['n_cover_url']['tmp_name']);
			$album->cover_url = $filename;
            unlink(public_path() . $params['cover_url']);
    	}
		$album->save();
    	return redirect('/admin/album');
    }

    public function destroy($id)
    {
    	$album = Album::where('id', $id)->first();
    	unlink(public_path() . $album->cover_url);
    	$album->delete();
    	return redirect('/admin/album');
    }

}


?>