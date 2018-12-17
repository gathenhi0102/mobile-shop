@extends('master')

@section('head')
<head>
<title>Đăng nhập</title>
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
<div class="login-form" style="margin-top: 50px">
	<div class="wrapper">
		<div class="container">
			<div class="row">
				<form role="form" action="{{route('postlogin')}}" method="post" class="form-signin">       
					<h3 class="form-signin-heading">Welcome Back! Please Sign In</h3>
					<hr class="colorgraph"><br>
					@if(count($errors) > 0)
					<div class="alert alert-danger" role="alert">
						@foreach($errors->all() as $err)
							{{$err}}<br>
						@endforeach
					</div>
					@endif

					@if(Session::has('flag'))
					<div class="alert alert-{{Session::get('flag')}}" role="alert">{{Session::get('message')}}</div>
					@endif
					
			  		<input id="token" type="hidden" name="_token" value="{{ csrf_token() }}">

					<input id="login_email" type="email" class="form-control" name="login_email" placeholder="Nhập email" value="{{old('login_email')}}" required="required" />
					<br>
					<input type="password" class="form-control" name="login_password" placeholder="Nhập password" required="required" />

					<div style="float: right;">
						<button id="forgotpassword" type="button" class="btn btn-link" data-toggle="modal" data-target="#forgotModal">Quên mật khẩu?</button>
					</div>

					<div style="margin-top: 50px">
						<button class="btn btn-lg btn-primary btn-block"  name="login_btn" value="Login" type="submit">Login</button>
					</div>	
					<div style="margin-top: 20px">
						<p>Bạn chưa có tài khoản? <a href="{{route('registerpage')}}"> Đăng kí tại đây</a></p>
					</div>

				</form>	
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="forgotModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">FORGOT YOUR PASSWORD?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          	<div class="form-group" id="forgotcontent">
            	<input type="text" class="form-control" id="recipient-email" placeholder="Vui lòng nhập email">
            	<input style="margin-top: 15px" type="text" class="form-control" id="phone_number" placeholder="Vui lòng nhập số điện thoại">
          	</div>
        </form>
      </div>
      <div class="modal-footer">
        <button id="showresultmodal" type="button" class="btn btn-primary">Lấy lại mật khẩu</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="resultModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">NOTIFICATION</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="notificationcontent"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
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