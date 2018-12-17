@extends('master')

@section('head')
<head>
<title>Chỉnh sửa thông tin người dùng</title>
<meta charset="utf-8">
<base href="{{asset('')}}">
<link rel="shortcut icon" href="source/images/o-ico.png">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="OneTech shop project">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="source/styles/bootstrap4/bootstrap.min.css">
<link href="source/plugins/fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="source/styles/cart_styles.css">
<link rel="stylesheet" type="text/css" href="source/styles/cart_responsive.css">
<link rel="stylesheet" type="text/css" href="source/styles/register_styles.css">
</head>
@endsection

@section('content')

<div class="container" style="margin-top: 50px;">
	<div class="row">
	    <div class="col-md-12">
	    	@if(Session::has('flag'))
	    	<div class="alert alert-{{Session::get('flag')}}" role="alert" style="text-align: center; font-size: large;">{{Session::get('message')}}</div>
	    	@endif
			<form role="form" method="post" action="{{route('saveprofile', $user_profile->id)}}" enctype="multipart/form-data">
				<h3 style="text-align: center;">THAY ĐỔI THÔNG TIN CÁ NHÂN</h3>
				<hr class="colorgraph">
				@if(count($errors) > 0)
				<div class="alert alert-danger" role="alert">
					@foreach($errors->all() as $err)
					{{$err}}<br>
					@endforeach
				</div>
				@endif
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
	                        <input type="text" name="input_name" id="input_name" class="form-control input-lg" placeholder="Nhập tên của bạn" tabindex="1" required="required" value="{{$user_profile->name}}">
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="form-group">
							<select class="form-control" name="sex_select" tabindex="2">
								<option hidden value="-1">Chọn giới tính</option>
								<option value="1" @if($user_profile->gender == 1) selected @endif>Nam</option>
								<option value="0" @if($user_profile->gender == 0) selected @endif>Nữ</option>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<input type="text" name="input_address" id="input_address" class="form-control input-lg" placeholder="Nhập địa chỉ của bạn" tabindex="3" required="required" value="{{$user_profile->address}}">
				</div>

				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<span><p style="font-size: 1rem;">Chọn ảnh đại diện: <p>
								<input type="file" name="image">
							</span>
						</div>
					</div>
				</div>	
				
				<hr class="colorgraph">
				<div class="row">
					<div class="col-xs-12 col-md-6"><input type="submit" value="Lưu thay đổi" class="btn btn-primary btn-block btn-lg" tabindex="4"></div>
					<div class="col-xs-12 col-md-6">
						<a href="{{route('userprofile', $user_profile->id)}}" type="button" class="btn btn-danger btn-block btn-lg">Thoát</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

@endsection


@section('script')
<script src="source/js/jquery-3.3.1.min.js"></script>
<script src="source/styles/bootstrap4/popper.js"></script>
<script src="source/styles/bootstrap4/bootstrap.min.js"></script>
<script src="source/plugins/greensock/TweenMax.min.js"></script>
<script src="source/plugins/greensock/TimelineMax.min.js"></script>
<script src="source/plugins/scrollmagic/ScrollMagic.min.js"></script>
<script src="source/plugins/greensock/animation.gsap.min.js"></script>
<script src="source/plugins/greensock/ScrollToPlugin.min.js"></script>
<script src="source/plugins/easing/easing.js"></script>
<script src="source/js/header.custom.js"></script>
<script src="source/js/register.custom.js"></script>
@endsection