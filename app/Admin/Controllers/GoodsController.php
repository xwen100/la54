<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Grid;
use Encore\Admin\Form;

use App\GoodsCat;
use App\Good;

class GoodsController extends Controller
{
    use ModelForm;

    public function index()
    {
    	return Admin::content(function(Content $content){
    		$content->header('商品列表');
    		$content->body($this->grid());
    	});
    }

    private function grid()
    {
    	return Admin::grid(Good::class, function(Grid $grid){
    		$grid->disableExport();
    		$grid->disableFilter();
            $grid->model()->orderBy('id', 'desc');
			$grid->id('ID');
			$grid->sn('编号');
			$grid->name('名称');
			$grid->logo('Logo')->display(function($v){
                return '<img src="'.$v.'" class="img img-thumbnail" width="80" >';
			});
            $grid->cat_id('分类')->display(function($cat_id){
                $cat = GoodsCat::find($cat_id);
                if($cat->id != 0)
                {
                    return $cat->name; 
                }
                return '未分类';
            });
			$grid->is_rec('是否推荐')->value(function($v){
				switch ($v) {
					case 0:
						return '否';
					case 1:
						return '是';
				}
			});
			$grid->price('价格');
			$grid->created_at('发布时间');
    		$grid->updated_at('更新时间');
    	});
    }

    public function create()
    {
    	return Admin::content(function (Content $content) {

            $content->header('添加商品');

            $content->body($this->form());
        });
    }

    private function form()
    {
    	return Admin::form(Good::class, function(Form $form){
    		$form->text('name', '名称');
    		$cats = GoodsCat::all();
    		$arr = array_combine(
                        $cats->pluck('id')->toArray(), 
                        $cats->pluck('name')->toArray()
                    );
            if(empty($arr)) $arr = [0=>'未分类'];
            $form->select('cat_id', '分类')->options($arr);
            $root = public_path() . '/upload/';
			$dir = 'goods/' . date('Ymd');
			if(!is_dir($root . $dir))
			{
				mkdir($dir, 0777, true);
			}
			$name = md5(uniqid()) . '.jpg';
           	$form->image('logo', 'Logo')->move($dir, $name);
           	$form->currency('price', '价钱')->symbol('￥');
           	$states = [
                'on'  => ['value' => 1, 'text' => '打开', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => '关闭', 'color' => 'danger'],
            ];
    		$form->switch('is_rec', '是否推荐')->states($states);
    		$form->keditor('desc', "描述");
    		if(request()->method() == 'POST'){
	    		$form->saved(function(Form $form){
	    				$good = Good::where('name', $form->name)->first();
	    				$good->sn = 'XWEN'. $good->id .time();
	    				$good->logo = '/upload/' . $good->logo;
	    				$good->save();
	    			});
    		}
    	});
    }

    public function edit($id)
    {
    	return Admin::content(function (Content $content) use ($id) {

            $content->header('编辑商品');

            $content->body($this->Editform()->edit($id));
        });
    }

    private function Editform()
    {
    	return Admin::form(Good::class, function(Form $form){
    		$form->text('name', '名称');
    		$cats = GoodsCat::all();
    		$arr = array_combine(
                        $cats->pluck('id')->toArray(), 
                        $cats->pluck('name')->toArray()
                    );
            if(empty($arr)) $arr = [0=>'未分类'];
            $form->select('cat_id', '分类')->options($arr);
            $form->display('logo', 'Logo')->with(function($v){
						return '<img src="'.$v.'" class="img img-thumbnail" width="200" >';
		    		});
           	$form->currency('price', '价钱')->symbol('￥');
           	$states = [
                'on'  => ['value' => 1, 'text' => '打开', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => '关闭', 'color' => 'danger'],
            ];
    		$form->switch('is_rec', '是否推荐')->states($states);
    		$form->keditor('desc', "描述");
    	});
    }

}