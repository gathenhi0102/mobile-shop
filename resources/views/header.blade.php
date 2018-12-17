<!-- Header -->

<header class="header">

	<!-- Top Bar -->

	<div class="top_bar">
		<div class="container">
			<div class="row">
				<div class="col d-flex flex-row">
					<div class="top_bar_contact_item"><div class="top_bar_icon"><img src="source/images/phone.png" alt=""></div>This site is just a test project</div>
					<div class="top_bar_content ml-auto">
						<div class="top_bar_menu">
							<ul class="standard_dropdown top_bar_dropdown">
								@if(!Auth::check())
								<li>
									<a href="{{route('inputorderinfo')}}">Kiểm tra đơn hàng<i class="fas fa-chevron-down"></i></a>
								</li>
								@else
								<li>
									<a href="{{route('userprofile',Auth::user()->id)}}">Xin chào: {{Auth::user()->name}}<i class="fas fa-chevron-down"></i></a>
									<ul>
										<li><a href="{{route('userprofile',Auth::user()->id)}}">Thông tin cá nhân</a></li>
										<li><a href="{{route('changepassword')}}">Đổi mật khẩu</a></li>
										<li><a href="{{route('getorderinfo',['order_email' => Auth::user()->email, 'order_phone' => Auth::user()->phone])}}">Kiểm tra đơn hàng</a></li>
										<li><a href="{{route('logout')}}">Đăng xuất</a></li>
									</ul>
								</li>
								@endif
							</ul>

						</div>
						@if(!Auth::check())
						<div class="top_bar_user">
							<div class="user_icon"><img src="source/images/user.svg" alt=""></div>
							<div><a href="{{route('registerpage')}}">Register</a></div>
							<div><a href="{{route('loginpage')}}">Sign in</a></div>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>		
	</div>

	<!-- Header Main -->

	<div class="header_main">
		<div class="container">
			<div class="row">

				<!-- Logo -->
				<div class="col-lg-2 col-sm-3 col-3 order-1">
					<div class="logo_container">
						<div class="logo"><a href="{{route('mainpage')}}">OneTech</a></div>
					</div>
				</div>

					<!-- Search -->
					<div class="col-lg-6 col-12 order-lg-2 order-3 text-lg-left text-right">
						<div class="header_search">
							<div class="header_search_content">
								<div class="header_search_form_container">
									<form action="{{route('search')}}" method="get" class="header_search_form clearfix">
										<input type="search" name="search" required="required" class="header_search_input" placeholder="Search for products...">
										<input id="input_type" type="hidden" name="category_selected">
										<div class="custom_dropdown">
											<div class="custom_dropdown_list">
												<span class="custom_dropdown_placeholder clc">All Categories</span>
												<i class="fas fa-chevron-down"></i>
												<ul class="custom_list clc" id="selected_type">
													<li value="0"><a class="clc" href="">All Categories</a></li>
													@foreach($category as $cate)
													<li value="{{$cate->id}}"><a class="clc" href="">{{$cate->name}}</a></li>
													@endforeach
												</ul>
											</div>
										</div>
										<button type="submit" class="header_search_button trans_300" value="Submit"><img src="source/images/search.png" alt=""></button>
									</form>
								</div>
							</div>
						</div>
					</div>

					<!-- Wishlist -->
					<div class="col-lg-4 col-9 order-lg-3 order-2 text-lg-left text-right">
						<div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
							<div class="wishlist d-flex flex-row align-items-center justify-content-end">
								<div class="wishlist_icon"><img src="source/images/heart.png" alt=""></div>
								<div class="wishlist_content">
									<div class="wishlist_text"><a href="#">Yêu thích</a></div>
									<div class="wishlist_count">0</div>
								</div>
							</div>

							<!-- Cart -->
							<div class="cart">
								<div class="cart_container d-flex flex-row align-items-center justify-content-end">
									<div class="cart_icon">
										<a href="{{route('cartinfo')}}">
											<img src="source/images/cart.png" alt="">
										</a>
										@if($total_item > 999)
											<div class="cart_count" title="{{$total_item}}"><span>...</span></div>
										@else
											<div class="cart_count"><span>{{$total_item}}</span></div>
										@endif
										
									</div>
									<div class="cart_content">
										<div class="cart_text"><a href="{{route('cartinfo')}}">Cart</a></div>
										<div class="cart_price">{{$total_price}} đ</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<!-- Main Navigation -->

		<nav class="main_nav">
			<div class="container">
				<div class="row">
					<div class="col">
						
						<div class="main_nav_content d-flex flex-row">

							<!-- Categories Menu -->

							<div class="cat_menu_container">
								<div class="cat_menu_title d-flex flex-row align-items-center justify-content-start">
									<div class="cat_burger"><span></span><span></span><span></span></div>
									<div class="cat_menu_text">DANH MỤC</div>
								</div>

								<ul class="cat_menu">
									@foreach($trademark as $trad)
									<li><a href="{{route('producttrademark', $trad->id)}}">{{$trad->name}}<i class="fas fa-chevron-right"></i></a></li>
									@endforeach
								</ul>
							</div>

							<!-- Main Nav Menu -->

							<div class="main_nav_menu ml-auto">
								<ul class="standard_dropdown main_nav_dropdown">
									<li><a href="{{route('mainpage')}}">Trang chủ<i class="fas fa-chevron-down"></i></a></li>
									@foreach($category as $cate)
									<li><a href="{{route('productcategory', $cate->id)}}">{{$cate->name}}<i class="fas fa-chevron-down"></i></a>
									@endforeach	
									<li><a href="">Sửa chữa<i class="fas fa-chevron-down"></i></a>
									<li><a href="">Khuyến mãi<i class="fas fa-chevron-down"></i></a></li>
									<li><a href="#footer">Liên hệ<i class="fas fa-chevron-down"></i></a></li>
								</ul>
							</div>

							<!-- Menu Trigger -->

							<div class="menu_trigger_container ml-auto">
								<div class="menu_trigger d-flex flex-row align-items-center justify-content-end">
									<div class="menu_burger">
										<div class="menu_trigger_text">menu</div>
										<div class="cat_burger menu_burger_inner"><span></span><span></span><span></span></div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</nav>
		
		<!-- Menu -->

	</header>