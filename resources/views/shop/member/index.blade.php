@extends('layouts.shop')

@section('content')

<div class="container">
	<div class="row">
        <div class="col-md-2">
            @include('shop/member/right')
        </div>
        <div class="col-md-10">
        member center
        </div>
    </div>
</div>

@endsection