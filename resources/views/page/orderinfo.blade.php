@extends('master')

@section('head')
<head>
<title>Danh sách đơn hàng</title>
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
<link rel="stylesheet" type="text/css" href="source/styles/login_styles.css">
</head>
@endsection

@section('content')

<?php
/*
1: Mới
2: Đang xác nhận
3: Đã xác nhận
4: Đang đóng gói sản phẩm
5: Đổi kho xuất hàng
6: Chờ đi nhận
7: Đang đi nhận
8: Đã nhận hàng
9: Đang chuyển
11: Thất bại
14: Hết hàng
*/
$orderstt_arr = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 11, 14);
?>

<div class="container" style="margin-top: 50px">

	@if(Session::has('flag'))
	    <div class="alert alert-{{Session::get('flag')}}" role="alert" style="text-align: center; font-size:large;">{{Session::get('message')}}</div>
	@endif
	<input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
	@foreach($tran_data as $tran)
  	<div class="card" style="margin-top: 20px">
    	<div class="card-header" id="heading{{$tran->id}}">
      		<h5 class="mb-0">
        	<button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{$tran->id}}" aria-expanded="true" aria-controls="collapse{{$tran->id}}">THÔNG TIN ĐƠN HÀNG</button>
     		</h5>
    	</div>

    	<div id="collapse{{$tran->id}}" class="collapse show" aria-labelledby="heading{{$tran->id}}" data-parent="#accordion">
      		<div class="card-body">	
      			<div class="row">
        			<div class="col-xs-12 col-sm-6 col-md-2">
        				<div class="form-group">
							<label>Mã đơn hàng:</label>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-4">
        				<div class="form-group">
							<label>{{$tran->id}}</label>
						</div>
					</div>
					
					<div class="col-xs-12 col-sm-6 col-md-2">
        				<div class="form-group">
							<label>Trạng thái:</label>
						</div>
					</div>
					
					<div class="col-xs-12 col-sm-6 col-md-4">
        				<div class="form-group">
							<label>{{$tran->status_name}}</label>
						</div>
					</div>
        		</div>

        		<div class="row">
        			<div class="col-xs-12 col-sm-6 col-md-2">
        				<div class="form-group">
							<label>Tổng tiền:</label>
						</div>
					</div>

					<div class="col-xs-12 col-sm-6 col-md-4">
        				<div class="form-group">
							<label>{{number_format($tran->total_amount,0,',','.')}} đ</label>
						</div>
					</div>
					
					<div class="col-xs-12 col-sm-6 col-md-2">
        				<div class="form-group">
							<label>Ngày tạo:</label>
						</div>
					</div>
					
					<div class="col-xs-12 col-sm-6 col-md-4">
        				<div class="form-group">
							<label>{{$tran->created_at}}</label>
						</div>
					</div>
        		</div>

				<div class="row">
        			<div class="col-xs-12 col-sm-6 col-md-2">
        				<div class="form-group">
							<label style="color: #ff0000">Ghi chú đơn hàng:</label>
						</div>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-10">
        				<div class="form-group">
							<label style="color: #ff0000">{{$tran->note}}</label>
						</div>
					</div>
				</div>
					
				@if(Auth::check() && in_array( $tran->status_id, $orderstt_arr))
        		<div class="row">
        			<div class="col-xs-2 col-sm-2 col-md-2">
        				<div class="form-group">
							<a href="{{route('cancelorder', $tran->id)}}" role = "button" ><button type="button" class="btn btn-primary btn-sm">Hủy đơn hàng</button></a>
						</div>
					</div>
				</div>
				@endif
				
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="form-group">
							<table class="table table-striped" style="margin-top: 20px">
								<thead>
								    <tr>
								      	<th scope="col">Tên sản phẩm</th>
								      	<th scope="col">Số lượng</th>
								      	<th scope="col">Tổng tiền</th>
								      	<th scope="col">Trạng thái</th>
								      	@if(Auth::check() && in_array( $tran->status_id, $orderstt_arr))
								      	<th scope="col"></th>
								      	@endif
								    </tr>
								</thead>
						  	<tbody>
						  		@foreach($tran->listmembers as $order_members)
						    	<tr>
						    		@if(strlen($order_members->product_name) < 30)
						    		<td>{{$order_members->product_name}}</td>
						    		@else
						    		<td title="{{$order_members->product_name}}">{{mb_substr($order_members->product_name,0,27)}}...</td>
						    		@endif
						      		<td>{{$order_members->quantity}}</td>
						      		<td>{{number_format($order_members->amount,0,',','.')}} đ</td>
						      		<td>{{$order_members->orders_stt}}</td>
						      		@if(Auth::check() && in_array( $tran->status_id, $orderstt_arr))
						      		<td><a href="{{route('cancelsuborders', $order_members->id)}}"><button type="button" class="close" aria-label="Close" title="Hủy sản phẩm"><span aria-hidden="true">&times;</span></button></a></td>
						      		@endif
						    	</tr>
						    	@endforeach
						  	</tbody>
							</table>
						</div>
					</div>
				</div>

      		</div>
    	</div>
  	</div>
  	@endforeach

  	<div class="shop_page_nav d-flex flex-row">
		{{$tran_data->links()}}
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