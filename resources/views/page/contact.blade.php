@extends('master')

@section('head')
<head>
<title>Đặt hàng</title>
<link rel="shortcut icon" href="source/images/o-ico.png">
<meta charset="utf-8">
<base href="{{asset('')}}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="OneTech shop project">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="source/styles/bootstrap4/bootstrap.min.css">
<link href="source/plugins/fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="source/styles/contact_styles.css">
<link rel="stylesheet" type="text/css" href="source/styles/contact_responsive.css">
</head>
@endsection

@section('content')

<!-- Contact Info -->

	<div class="contact_info">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="contact_info_container d-flex flex-lg-row flex-column justify-content-between align-items-between">

						<!-- Contact Item -->
						<div class="contact_info_item d-flex flex-row align-items-center justify-content-start">
							<div class="contact_info_image"><img src="source/images/contact_1.png" alt=""></div>
							<div class="contact_info_content">
								<div class="contact_info_title">Phone</div>
								<div class="contact_info_text">+84 167 518 3919</div>
							</div>
						</div>

						<!-- Contact Item -->
						<div class="contact_info_item d-flex flex-row align-items-center justify-content-start">
							<div class="contact_info_image"><img src="source/images/contact_2.png" alt=""></div>
							<div class="contact_info_content">
								<div class="contact_info_title">Email</div>
								<div class="contact_info_text">long.nguyenvan95@gmail.com</div>
							</div>
						</div>

						<!-- Contact Item -->
						<div class="contact_info_item d-flex flex-row align-items-center justify-content-start">
							<div class="contact_info_image"><img src="source/images/contact_3.png" alt=""></div>
							<div class="contact_info_content">
								<div class="contact_info_title">Address</div>
								<div class="contact_info_text">Kp6, Linh Trung, Thủ Đức, Tp HCM</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- orders description -->

	<div class="contact_form">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="contact_form_container">
						<div class="contact_form_title">Thông tin đơn hàng</div>

						<?php 
							$tran_fee = 0;
							if($total_price < 5000000)
								 $tran_fee = $total_price*0.02;
						?>	

						<form id="orders_info_form">
							<div class="form-group">
								<div class="row">
									<div class="col-md-3">
										<label>Tổng số sản phẩm:</label>
									</div>
									<div class="col-md-2">
										@if($total_item==0)
										<label>Không có dữ liệu</label>
										@else
										<label>{{$total_item}}</label>
										@endif
									</div>
									<div class="col-md-2">
										<label>Phí giao hàng:</label>
									</div>
									<div class="col-md-2">
										@if($total_item==0)
										<label style="color: red">Không có dữ liệu</label>
										@elseif($tran_fee==0)
										<label style="color: red">Miễn phí</label>
										@else
										<label>{{number_format($tran_fee,0,',','.')}} đ</label>
										@endif
									</div>
								</div>
							</div>

							<div class="form-group">
								@if($total_item==0)
								<fieldset disabled>
								@else
								<fieldset>
								@endif	
								<div class="row">
									<div class="col-md-3">
										<input type="text" class="form-control" name="" placeholder="Nhập mã giảm giá">
									</div>
									<div class="col-md-2">
										<button class="btn btn-primary" type="button">Áp dụng</button>
									</div>
								</div>
								</fieldset>
							</div>

							<div class="form-group">
							</div>

							<div class="form-group">
								<div class="row">
									<div class="col-md-3">
										<label>Tổng tiền thanh toán:</label>
									</div>
									<div class="col-md-3">
										@if($total_item==0)
										<label style="color: #f57224">Không có dữ liệu</label>
										@else
										<label style="color: #f57224">{{number_format($total_price+$tran_fee,0,',','.')}} đ</label>
										@endif
									</div>
									<div class="col-md-3">
										
									</div>
								</div>
							</div>
							
							@if($total_item!=0)

							<div class="form-group">
								<div class="row">
									<div class="col-md-12">
										<table class="table table-striped">
										  	<thead>
											  	<tr>
											      	<th scope="col">Tên sản phẩm</th>
											      	<th scope="col">Số lượng</th>
											      	<th scope="col">Đơn giá</th>
											      	<th scope="col">Thành tiền</th>
											    </tr>
										  	</thead>
										  	<tbody>
											@foreach($cart as $item)
												<tr>
												@if(strlen($item->name) < 30)
													<td>{{$item->name}}</td>
													@else
													<td title="{{$item->name}}">{{mb_substr($item->name,0,30)}}...</td>
													@endif
													<td>{{$item->qty}}</td>
													<td>{{number_format($item->price,0,',','.')}} đ</td>
													<td>{{number_format($item->qty*$item->price,0,',','.')}} đ</td>
												</tr>
											@endforeach
										  	</tbody>
										</table>
									</div>
								</div>
							</div>

							@endif	
						</form>

					</div>
				</div>
			</div>
		</div>
		<div class="panel"></div>
	</div>

<!-- Contact Form -->

	<div class="contact_form">
		<div class="container">
			<div class="row">
				<div class="col-lg-10 offset-lg-1">
					<div class="contact_form_container">
						<div class="contact_form_title">Thông tin giao hàng</div>

						<form method="post" action="{{route('orders')}}" id="contact_form">
						@if($total_item==0)
						<fieldset disabled>
						@else	
						<fieldset>
						@endif
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<div class="contact_form_inputs d-flex flex-md-row flex-column justify-content-between align-items-between">
								<input type="text" name="contact_form_name" class="contact_form_name input_field" placeholder="Nhập tên của bạn" required="required" data-error="Name is required."
								@if(Auth::check()) value="{{Auth::user()->name}}" @endif>
								<input type="text" name="contact_form_email" class="contact_form_email input_field" placeholder="Nhập email của bạn" required="required" data-error="Email is required."@if(Auth::check()) value="{{Auth::user()->email}}" @endif>
							</div>

							<div class="contact_form_inputs d-flex flex-md-row flex-column justify-content-between align-items-between">
								<input type="text" id="contact_form_phone" name="contact_form_phone" class="contact_form_phone input_field" placeholder="Nhập số điện thoại của bạn" required="required" maxlength="15" @if(Auth::check()) value="{{Auth::user()->phone}}" @endif>
								<input type="text" name="contact_form_address" class="contact_form_address input_field" placeholder="Nhập địa chỉ của bạn" required="required" @if(Auth::check()) value="{{Auth::user()->address}}" @endif>
							</div>

							<div class="contact_form_text">
								<textarea id="" class="text_field contact_form_message" name="contact_form_description" rows="3" placeholder="Bạn có ghi chú gì không?"></textarea>
							</div>

							<div class="contact_form_button">
								<button type="submit" class="button contact_submit_button">Xác nhận</button>
							</div>
						</fieldset>	
						</form>

					</div>
				</div>
			</div>
		</div>
		<div class="panel"></div>
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
<script src="source/js/contact_custom.js"></script>
@endsection