<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\InfoBox;

use App\User;
use App\Article;

class HomeController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('仪表盘');

            $userCount = User::count();
            $articleCount = Article::count();

            $content->row(function (Row $row) use ($userCount, $articleCount) {
                $row->column(3, new InfoBox('会员总数', 'users', 'aqua', '/admin/users', $userCount));
                $row->column(3, new InfoBox('文章总数', 'stack-overflow', 'olive', '/admin/article', $articleCount));
            });

        });
    }
}
