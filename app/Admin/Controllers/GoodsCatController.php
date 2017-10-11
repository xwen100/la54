<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Grid;
use Encore\Admin\Form;

use App\GoodsCat;

class GoodsCatController extends Controller
{
    use ModelForm;

    public function index()
    {
    	return Admin::content(function(Content $content){
    		$content->header('分类列表');
    		$content->body($this->grid());
    	});
    }
    private function grid()
    {
    	return Admin::grid(GoodsCat::class, function(Grid $grid){
    		$grid->disableExport();
    		$grid->disableFilter();
    		$grid->id('ID');
    		$grid->name('名称');
    	});
    }
    public function create()
    {
    	return Admin::content(function(Content $content){
    		$content->header('添加分类');
    		$content->body($this->form());
    	});
    }
    private function form()
    {
    	return Admin::form(GoodsCat::class, function(Form $form){
    		$form->text('name', '名称');
    	});
    }
}