@extends('layouts.shop')

@section('content')

<div class="container">
	<div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">登录</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="/shop/login">
                        {{ csrf_field() }}

						<div class="form-group">
                            <label class="col-md-4 control-label">用户名</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="username">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">密码</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    登录
                                </button>

                                <a class="btn btn-link" href="/shop/register">
                                    注册
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
