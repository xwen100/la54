<div class="cat_wrap">
    <h3>分类</h3>
    <div class="list-group">
    	@foreach($catList as $k => $v)
        <a href="{{url('home/index?cat='.$v['id'])}}" class="list-group-item">
            <span class="badge">{{$v['a_count']}}</span>{{$v['name']}}
        </a>
        @endforeach
    </div>
</div>