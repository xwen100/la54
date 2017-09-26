<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Grid;

use App\User;

class UsersController extends Controller
{
    use ModelForm;

    public function index()
    {
    	return Admin::content(function(Content $content){
    		$content->header('会员列表');
    		$content->body($this->grid());
    	});
    }

    private function grid()
    {
    	return Admin::grid(User::class, function(Grid $grid){
    		$grid->disableExport();
    		$grid->disableFilter();
            $grid->disableCreation();
            $grid->disableRowSelector();
    		$grid->name('昵称');
            $grid->email('邮件');
    		$grid->admin_id('管理员ID');
    		$grid->created_at('注册时间');
    		$grid->actions(function ($actions)
            {
                $actions->disableEdit();
                $actions->disableDelete();
            });
    	});
    }
}
