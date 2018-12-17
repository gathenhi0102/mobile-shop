@extends('master')

@section('head')
<head>
<title>Giỏ hàng</title>
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
</head>
@endsection

@section('content')
<!-- Cart -->

<div class="cart_section">
	<div class="container">
		<div class="row">
			<div class="col-lg-10 offset-lg-1">
				<div class="cart_container">
				@if(empty(count($cart)))
					<div style="margin-top: 20px">
						<h4>Không có sản phẩm nào trong giỏ hàng.</h4>
					</div>
				@else	
					<div class="cart_title">Giỏ hàng của tôi</div>
					@foreach($cart as $item)
					<div class="cart_items">
						<ul class="cart_list">
							<li class="cart_item clearfix">
								<div class="cart_item_image"><img src = "{{$item->options->image}}" alt="{{$item->name}}" title="{{$item->name}}"></div>
								<div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
									<div class="cart_item_name cart_info_col">
										<div class="cart_item_title">Tên sản phẩm</div>
										@if(strlen($item->name) <= 12)
											<div class="cart_item_text" title="{{$item->name}}">{{$item->name}}</div>
										@else
											<div class="cart_item_text" title="{{$item->name}}">{{mb_substr($item->name,0,12)}}...</div>
										@endif
									</div>
									<div class="cart_item_color cart_info_col">
										<div class="cart_item_title">Màu sắc</div>
										<div class="cart_item_text"><span style="background-color:#999999;"></span>Silver</div>
									</div>
									<div class="cart_item_quantity cart_info_col">
										<div class="cart_item_title">Số lượng</div>
										<div class="cart_item_text">{{$item->qty}}</div>
									</div>
									<div class="cart_item_price cart_info_col">
										<div class="cart_item_title">Đơn giá</div>
										<div class="cart_item_text">{{number_format($item->price,0,',','.')}} đ</div>
									</div>

									<div class="cart_item_delete">
										<a href="{{route('delcart', $item->rowId)}}"><button type="button" class="close" aria-label="Close" title="Remove">
          									<span aria-hidden="true">&times;</span>
        								</button></a>
									</div>
								</div>
							</li>
						</ul>
					</div>
					@endforeach
						
					<!-- Order Total -->
					<div class="order_total">
						<div class="order_total_content text-md-right">
							<div class="order_total_title">Tổng cộng:</div>
							<div class="order_total_amount">{{$total}} đ</div>
						</div>
					</div>

					<div class="cart_buttons">
						<a href="{{route('mainpage')}}"><button type="button" class="button cart_button_clear">Tiếp tục mua hàng</button></a>
						<a href="{{route('contactpage')}}"><button type="button" class="button cart_button_checkout">Tiến hành thanh toán</button></a>
					</div>
				</div>
			@endif	
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
<script src="source/js/cart_custom.js"></script>
@endsection