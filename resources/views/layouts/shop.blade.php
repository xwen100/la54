<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} 商城</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/shop.css') }}" rel="stylesheet">
</head>
<body>
	<div id="app">
		<nav class="navbar navbar-default navbar-static-top">
			<div class="container">
				<div class="navbar-header">
					<a class="navbar-brand" href="{{ url('/shop/home') }}">
                        {{ config('app.name', 'Laravel') }} 商城
                    </a>
				</div>
	            <div class="collapse navbar-collapse" id="app-navbar-collapse">
	            	<ul class="nav navbar-nav navbar-right">
	            		<li>
	            			<a href="/shop/cart">
	            				<span class="glyphicon glyphicon-shopping-cart icon">
	            				</span>
	            			</a>
	            		</li>
                        <li>
                    		@if (Session::has('member_id'))
                    		<a href="/shop/member">{{Session::get('member_name')}}</a>
                    		@else
                    		<a href="/shop/login">
                    			<span class="glyphicon glyphicon-user">
            					</span>
            				</a>
            				@endif
                        	
                        </li>
	            	</ul>
	            </div>
			</div>
		</nav>
        @yield('content')
	</div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/shop.js') }}"></script>
</body>