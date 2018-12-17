@extends('master')

{{-- head page --}}
@section('head')
<head>
	<title>Trang chủ</title>
	<link rel="shortcut icon" href="source/images/o-ico.png"> 
	<base href="{{asset('')}}">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="OneTech shop project">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="source/styles/bootstrap4/bootstrap.min.css">
	<link href="source/plugins/fontawesome-free-5.0.1/css/fontawesome-all.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="source/plugins/OwlCarousel2-2.2.1/owl.carousel.css">
	<link rel="stylesheet" type="text/css" href="source/plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
	<link rel="stylesheet" type="text/css" href="source/plugins/OwlCarousel2-2.2.1/animate.css">
	<link rel="stylesheet" type="text/css" href="source/plugins/jquery-ui-1.12.1.custom/jquery-ui.css">
	<link rel="stylesheet" type="text/css" href="source/styles/shop_styles.css">
	<link rel="stylesheet" type="text/css" href="source/styles/shop_responsive.css">
</head>
@endsection

{{-- content page --}}

@section('content')

<!-- Home -->

<div class="home">
	<div class="home_background parallax-window" data-parallax="scroll" data-image-src="source/images/shop_background.jpg"></div>
	<div class="home_overlay"></div>
	<div class="home_content d-flex flex-column align-items-center justify-content-center">
		<h2 class="home_title"></h2>
	</div>
</div>

<!-- Shop -->

<div class="shop">
	<div class="container">
		<div class="row">
			<div class="col-lg-3">

				<!-- Shop Sidebar -->
				<div class="shop_sidebar">
					<div class="sidebar_section filter_by_section">
						<div class="sidebar_title">Lọc theo</div>
						<div class="sidebar_subtitle">Giá tiền</div>
						<div class="filter_price">
							<div id="slider-range" class="slider_range"></div>
							<p>Range: </p>
							<p><input type="text" id="amount" class="amount" readonly style="border:0; font-weight:bold;"></p>
						</div>
					</div>
					<div class="sidebar_section">
						<div class="sidebar_subtitle color_subtitle">Màu sắc</div>
						<ul class="colors_list">
							<li class="color"><a href="#" style="background: #E6E5EB;"></a></li>
							<li class="color"><a href="#" style="background: #000000;"></a></li>
							<li class="color"><a href="#" style="background: #ff6699;"></a></li>
							<li class="color"><a href="#" style="background: #0e8ce4;"></a></li>
							<li class="color"><a href="#" style="background: #df3b3b;"></a></li>
							<li class="color"><a href="#" style="background: #ffffff; border: solid 1px #e1e1e1;"></a></li>
						</ul>
					</div>
					<div class="sidebar_section">
						<div class="sidebar_subtitle brands_subtitle">Thương hiệu</div>
						<ul class="brands_list">
						@foreach($trademark as $trade)
							<li class="brand"><a href="{{route('producttrademark', $trade->id)}}">{{$trade->name}}</a></li>
						@endforeach
						</ul>
					</div>
				</div>

			</div>

			<div class="col-lg-9">
					
				<!-- Shop Content -->

				<div class="shop_content">
					<div class="shop_bar clearfix">
						<div class="shop_product_count"><span>{{count($product)}}</span> Sản phẩm</div>
						<div class="shop_sorting">
							<span>Sắp xếp theo:</span>
							<ul>
								<li>
									<span class="sorting_text">Giá thấp nhất<i class="fas fa-chevron-down"></span></i>
									<ul>
										<li class="shop_sorting_button" data-isotope-option='{ "sortBy": "price" }'>Giá thấp nhất</li>
										<li class="shop_sorting_button" data-isotope-option='{ "sortBy": "name" }'>Tên sản phẩm</li>
									</ul>
								</li>
							</ul>
						</div>
					</div>

					<div class="product_grid">
						<div class="product_grid_border"></div>

						{{-- product_item is_new: sản phẩm mới. có new ở trên đầu
						product_item discount: sản phẩm có giảm giá discount
						product_item: không có gì cả --}}
						@if($product->isEmpty())
							<div style="margin-top: 20px">
								<h4>Không tìm thấy sản phẩm nào.</h4>
							</div>
						@else

							@foreach($product as $prd)
							<!-- Product Item -->
							<div @if($prd->status==1)
							 		class="product_item"
							 	 @else
							 	 	class="product_item is_new"
							 	@endif>
								<div class="product_border"></div>
								<div class="product_image d-flex flex-column align-items-center justify-content-center">
									<a href="{{route('productpage', $prd->id)}}"><img src="{{$prd->main_image}}" title="{{$prd->name}}" alt="{{$prd->name}}">
									</a>
								</div>
								<div class="product_content">
									<div class="product_price">{{number_format($prd->original_price,0,',','.')}} đ</div>
									<div class="product_name">
										<div>
											@if(strlen($prd->name) <= 20)
												<a href="{{route('productpage', $prd->id)}}" tabindex="0">{{$prd->name}}</a>
											@else
												<a href="{{route('productpage', $prd->id)}}" tabindex="0">{{mb_substr($prd->name,0,20)}}...</a>	
											@endif
										</div>
									</div>
								</div>
								<div class="product_fav"><i class="fas fa-heart"></i></div>
								<ul class="product_marks">
									{{-- <li class="product_mark product_discount">-25%</li> --}}
									<li class="product_mark product_new">new</li>
								</ul>
							</div>
							@endforeach
						@endif
					</div>
					<!-- Shop Page Navigation -->

					<div class="shop_page_nav d-flex flex-row">
						{{$product->links()}}
					</div>

				</div>

			</div>
		</div>
	</div>
</div>

<!-- Recently Viewed -->
{{-- @include('recentlyview') --}}

<!-- Brands -->
@include('brands')

<!-- Newsletter -->
@include('subscribe')

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
<script src="source/plugins/Isotope/isotope.pkgd.min.js"></script>
<script src="source/plugins/jquery-ui-1.12.1.custom/jquery-ui.js"></script>
<script src="source/plugins/parallax-js-master/parallax.min.js"></script>
<script src="source/js/header.custom.js"></script>
<script src="source/js/shop_custom.js"></script>
@endsection
