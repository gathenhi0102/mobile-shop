@extends('master')

{{-- head page --}}
@section('head')
<head>
	<title>Sản phẩm</title>
	<base href="{{asset('')}}">
	<meta charset="utf-8">
	<link rel="shortcut icon" href="source/images/o-ico.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="OneTech shop project">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="source/styles/bootstrap4/bootstrap.min.css">
	<link href="source/plugins/fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="source/plugins/OwlCarousel2-2.2.1/owl.carousel.css">
	<link rel="stylesheet" type="text/css" href="source/plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
	<link rel="stylesheet" type="text/css" href="source/plugins/OwlCarousel2-2.2.1/animate.css">
	<link rel="stylesheet" type="text/css" href="source/styles/product_styles.css">
	<link rel="stylesheet" type="text/css" href="source/styles/product_responsive.css">
</head>
@endsection

{{-- content page --}}
@section('content')

<!-- Single Product -->

<div class="single_product">
	<div class="container">
		<div class="row">

			<!-- Images -->
			{{-- <div class="col-lg-2 order-lg-1 order-2">
				<ul class="image_list">
					<li data-image="images/single_4.jpg"><img src="source/images/single_4.jpg" alt=""></li>
					<li data-image="images/single_2.jpg"><img src="source/images/single_2.jpg" alt=""></li>
					<li data-image="images/single_3.jpg"><img src="source/images/single_3.jpg" alt=""></li>
				</ul>
			</div> --}}

			<!-- Selected Image -->
			<div class="col-lg-5 order-lg-2 order-1">
				<div class="image_selected"><img src="{{$product_inf->main_image}}" alt="{{$product_inf->name}}" title="{{$product_inf->name}}"></div>
			</div>

			<!-- Description -->
			<div class="col-lg-5 order-3">
				<div class="product_description">
					<div class="product_category">{{$category->name}}</div>
					<div class="product_name">{{$product_inf->name}}</div>
					<div class="rating_r rating_r_4 product_rating"><i></i><i></i><i></i><i></i><i></i></div>
					<div class="product_text">
						@if(empty($product_inf->description))
							<p>Không có mô tả nào cho sản phẩm này.</p>
						@else
							<p>{{$product_inf->description}}</p>
						@endif
					</div>
					<div class="order_info d-flex flex-row">
						<form method="post" action="{{route('addtocart')}}">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="product_id" value="{{$product_inf->id}}">
							<div class="clearfix" style="z-index: 1000;">

								<!-- Product Quantity -->
								<div class="product_quantity clearfix">
									<span>Quantity: </span>
									<input id="quantity_input" name="quantity_input" type="text" pattern="[0-9]*" value="1" readonly>
									<div class="quantity_buttons">
										<div id="quantity_inc_button" class="quantity_inc quantity_control"><i class="fas fa-chevron-up"></i></div>
										<div id="quantity_dec_button" class="quantity_dec quantity_control"><i class="fas fa-chevron-down"></i></div>
									</div>
								</div>

								<!-- Product Color -->
								<ul class="product_color">
									<li>
										<span>Color: </span>
										<div class="color_mark_container"><div id="selected_color" class="color_mark"></div></div>
										<div class="color_dropdown_button"><i class="fas fa-chevron-down"></i></div>

										<ul class="color_list">
											<li><div class="color_mark" style="background: #999999;"></div></li>
											<li><div class="color_mark" style="background: #b19c83;"></div></li>
											<li><div class="color_mark" style="background: #000000;"></div></li>
										</ul>
									</li>
								</ul>

							</div>
							<div id="prodt_price" class="product_price">{{number_format($product_inf->original_price,0,',','.')}} đ
								{{-- <span style="margin-left: 10px; color: black"><strike>99.999.999đ</strike></span> --}}
							</div>
							<div class="button_container">
								@if($product_inf->quantity ==0)
								<button disabled="disabled" style="background-color: #d9534f" type="button" class="button cart_button">Tạm hết hàng</button>
								@else
								<button type="submit" class="button cart_button">Thêm vào giỏ hàng</button>
								@endif
								<div class="product_fav"><i class="fas fa-heart"></i></div>
							</div>
								
						</form>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<?php
	$param = $product_inf->parameters;
	$parameters = json_decode($param, true);
?>
<!-- Specifications -->
<div class="container">
	<div class="spectification_title_container">
		<h3 class="spectification_title">Thông tin sản phẩm</h3>
	</div>
	<div class="spectification_content_container">
		<table class="table table-striped">
			
	  		<tbody>
	  			@foreach($parameters as $key => $value)
				<tr>
					<th>{{$key}}</th>
				    <td>{{$value}}</td>
				</tr>
				@endforeach
	  		</tbody>

		</table>
	</div>
</div>

<!-- Recently Viewed -->

<div class="viewed">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="viewed_title_container">
					<h3 class="viewed_title">Các sản phẩm cùng loại</h3>
					<div class="viewed_nav_container">
						<div class="viewed_nav viewed_prev"><i class="fas fa-chevron-left"></i></div>
						<div class="viewed_nav viewed_next"><i class="fas fa-chevron-right"></i></div>
					</div>
				</div>

				<div class="viewed_slider_container">
						
				<!-- Recently Viewed Slider -->

					<div class="owl-carousel owl-theme viewed_slider">
						{{-- viewed_item is_new: mới viewed_item discount: giảm giá --}}
						@foreach($same_product as $same)		
						<!-- Recently Viewed Item -->
						<div class="owl-item">
							<div @if($same->status==1)
									class="viewed_item is_new d-flex flex-column align-items-center justify-content-center text-center"
								@else
									class="viewed_item d-flex flex-column align-items-center justify-content-center text-center"
								@endif>
								<div class="viewed_image">
									<a href="{{route('productpage', $same->id)}}">
										<img src="{{$same->main_image}}" alt="{{$same->name}}" title="{{$same->name}}">
									</a>
								</div>
								<div class="viewed_content text-center">
									<div class="viewed_price">{{number_format($same->original_price,0,',','.')}} đ{{-- <span>$300</span> --}}</div>
									<div class="viewed_name">
										<a href="{{route('productpage', $same->id)}}">
											@if(strlen($same->name) <= 12)
												{{$same->name}}
											@else
												{{mb_substr($same->name,0,12)}}...
											@endif
										</a>
									</div>
								</div>
								<ul class="item_marks">
									{{-- <li class="item_mark item_discount">-25%</li> --}}
									<li class="item_mark item_new">new</li>
								</ul>
							</div>
						</div>
						@endforeach

					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<!-- comment -->
<div class="container" style="margin-top: 50px;">
	<div class="spectification_title_container">
		<h3 class="comment_title">Nhận xét về sản phẩm</h3>
	</div>
	<div class="comment_content_container">
		<div class="comments">
			@if(Auth::check())
			<div class="comment-wrap">
				<div class="photo">
					<div class="avatar" style="background-image: url('source/user_image/{{Auth::user()->user_image}}')" title="{{Auth::user()->name}}">
						
					</div>
				</div>
				<div class="comment-block">
					<form method="post" action="{{route('postcomment')}}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<input type="hidden" name="product_id" value="{{$product_inf->id}}">
						<input type="hidden" name="user_id" value="{{Auth::user()->id}}">
						<input type="hidden" name="user_name" value="{{Auth::user()->name}}">
						<textarea name="feedback_content" id="" cols="30" rows="3" placeholder="Add comment..." style="color: #000000"></textarea>
						<button type="submit" class="btn btn-primary btn-sm">Gửi phản hồi</button>
					</form>
				</div>
			</div>
			@endif

			@if($product_feedback->isEmpty())
				<h4>Không có phản hồi nào về sản phẩm này.</h4>
			@else

			@foreach($product_feedback as $cmt)
			<div class="comment-wrap">
				<div class="photo">
					<div class="avatar" style="background-image: url('source/user_image/{{$cmt->user_image}}')" title="{{$cmt->user_name}}">
					</div>
				</div>
				<div class="comment-block" style="background-color: #f0f2fa">
					<p class="comment-text" style="color: #000000">{{$cmt->content}}</p>
					<div class="bottom-comment">
						<div class="comment-date">{{$cmt->created_at}}
						</div>
						{{-- <ul class="comment-actions">
							<li class="complain">Chỉnh sửa</li>
							<li class="reply">Xóa</li>
						</ul> --}}
					</div>
				</div>
			</div>
			@endforeach

			@endif

		</div>
	</div>
</div>


<!-- Brands -->
@include('brands')

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
<script src="source/plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="source/plugins/easing/easing.js"></script>
<script src="source/js/header.custom.js"></script>
<script src="source/js/product_custom.js"></script>
@endsection