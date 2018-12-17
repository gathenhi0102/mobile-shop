@extends('master')

@section('head')
<head>
<title>Thông tin người dùng</title>
<meta charset="utf-8">
<base href="{{asset('')}}">
<link rel="shortcut icon" href="source/images/o-ico.png">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="OneTech shop project">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="source/styles/bootstrap3/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="source/styles/bootstrap4/bootstrap.min.css">
<link href="source/plugins/fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="source/styles/cart_styles.css">
<link rel="stylesheet" type="text/css" href="source/styles/cart_responsive.css">
<link rel="stylesheet" type="text/css" href="source/styles/register_styles.css">
</head>
@endsection

@section('content')

<div class="container" style="margin-top: 50px">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 toppad">
         	<div class="panel panel-info">
	            <div class="panel-heading">
	              	<h3 class="panel-title">THÔNG TIN CÁ NHÂN</h3>
	            </div>
            	<div class="panel-body">
              		<div class="row">
                		<div class="col-md-3 col-lg-3 " align="center"> <img alt="{{$user_profile->name}}" src=" source/user_image/{{$user_profile->user_image}}" class="img-circle img-responsive" title="{{$user_profile->name}}"> </div>
                
	                	<div class=" col-md-9 col-lg-9 "> 
	                  		<table class="table table-user-information">
	                    		<tbody>
	                      			<tr>
	                        			<td>Họ và tên</td>
	                       	 			<td>{{$user_profile->name}}</td>
	                      			</tr>

	                      			<tr>
				                        <td>Email</td>
				                        <td>{{$user_profile->email}}</td>
	                      			</tr>
	                      			<tr>
	                        			<td>Điện thoại</td>
	                        			<td>{{$user_profile->phone}}</td>
	                      			</tr>
	                   
	                             	<tr>
				                  		<td>Giới tính</td>
				                        <td>{{$user_profile->gender}}</td>
	                      			</tr>

	                        		<tr>
				                        <td>Địa chỉ</td>
				                        <td>{{$user_profile->address}}</td>
	                      			</tr>

	                      			<tr>
	                        			<td>Loại khách hàng</td>
	                        			<td>{{$user_profile->type_name}}</td>
	                      			</tr>

	                      			<tr>
										<td>Điểm tích lũy</td>
										<td>{{$user_profile->point}}</td>
	                      			</tr>
	                    		</tbody>
	                  		</table>
	                	</div>	
              		</div>
            	</div>
                <div class="panel-footer">
                	<a href="{{route('edituserprofile', $user_profile->id)}}" type="button" class="btn btn-success btn-lg">Chỉnh sửa</a>
                </div>
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
<script src="source/js/register.custom.js"></script>
@endsection
