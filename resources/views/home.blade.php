@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10">
        	@foreach($list['data'] as $k => $v)
			<div class="articl-wrap">
			    <h2>{{$v['title']}}</h2>
			    <p class="p1">作者： {{$v['username']}} • {{$v['created_at']}} </p>
			    <div class="d1">{{$v['desc']}}
			    </div>
			    <p class="p2">
			        <a href="{{url('home/read',$v['id'])}}" class="btn btn-default">阅读全文</a>
			    </p>
			    <hr>
			    <p class="p3">
			        <span class="glyphicon glyphicon-tag"></span>{{$v['name']}}
			    </p>
			</div>
			@endforeach
        </div>
        <div class="col-md-2">
            @include('right')
        </div>
    </div>
    <nav aria-label="...">
	  <ul class="pager">
	  	@if ($list['prev_page_url'] != null)
	    <li><a href="{{$list['prev_page_url']}}">上一页</a></li>
	    @else
	    <li class="disabled"><a href="javascript:;">上一页</a></li>
	    @endif
	  	@if ($list['next_page_url'] !== null)
	    <li><a href="{{$list['next_page_url']}}">下一页</a></li>
	    @else
	    <li class="disabled"><a href="javascript:;">下一页</a></li>
	    @endif
	  </ul>
	</nav>
</div>

@endsection

