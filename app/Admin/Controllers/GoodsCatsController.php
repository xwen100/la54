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
    		$content->header('商品分类列表');
    		//$content->body($this->grid());
    	});
    }
}