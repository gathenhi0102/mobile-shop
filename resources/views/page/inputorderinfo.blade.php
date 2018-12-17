@extends('master')

@section('head')
<head>
<title>Tra cứu thông tin đơn hàng</title>
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
<link rel="stylesheet" type="text/css" href="source/styles/login_styles.css">
</head>
@endsection

@section('content')
<div class="container" style="margin-top: 50px;">
	<div class="row">
	    <div class="col-md-12">
			@if(Session::has('message'))
	    	<div class="alert alert-danger" role="alert" style="text-align: center; font-size: large;">{{Session::get('message')}}</div>
			@endif
	    	<form role="form" method="get" action="{{route('getorderinfo')}}">
				<h3 style="text-align: center;">TRA CỨU THÔNG TIN ĐƠN HÀNG</h3>
				<hr class="colorgraph">
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="email" name="order_email" id="order_email" class="form-control input-lg" placeholder="Nhập email của bạn" tabindex="1" required="required" value="">
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6">
						<div class="form-group">
							<input type="text" name="order_phone" id="order_phone" class="form-control input-lg" placeholder="Nhập số điện thoại của bạn" tabindex="2" required="required" value="" maxlength="15">
						</div>
					</div>
				</div>
				<hr class="colorgraph">
				<div class="row">
					<div class="col-md-12"><input type="submit" value="Xem thông tin đơn hàng" class="btn btn-primary btn-block btn-lg" tabindex="3"></div>
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
@endsection