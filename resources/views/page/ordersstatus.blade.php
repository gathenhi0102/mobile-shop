@extends('master')

@section('head')
<head>
<title>Thông tin đặt hàng</title>
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
{{-- customer infomation --}}
<div class="contact_info">
	<div class="container">
		@if($status==0)
		<div class="alert alert-danger" role="alert" style="text-align: center; font-size: x-large;">
  			ĐẶT HÀNG THẤT BẠI
		</div>
		<div style="margin-top: 20px";>
			<h4 style="color: red">OOPS. CÓ LỖI XẢY RA TRONG QUÁ TRÌNH ĐẶT HÀNG.</h4>
			<br>
			<h4>Bạn vui lòng thực hiện lại quá trình đặt hàng, nếu tiếp tục bị lỗi, vui lòng liên hệ với admin theo số phone support ở góc trên cùng bên trái màn hình nhé.</h4>
			<br>
			<h4>Chúng tôi rất xin lỗi về sự bất tiện này.</h4>
		</div>
		<a href="{{route('cartinfo')}}"><button type="button" class="btn btn-primary">Đặt hàng lại</button></a>
	
		@elseif(empty($tran_info))

		<div class="alert alert-warning" role="alert" style="text-align: center; font-size: x-large;">
  			ĐƠN HÀNG KHÔNG HỢP LỆ
		</div>

		@else
		<div class="alert alert-success" role="alert" style="text-align: center; font-size: x-large;">
  			ĐẶT HÀNG THÀNH CÔNG
		</div>
		<div class="card">
    		<div class="card-header" id="headingOne">
      			<h5 class="mb-0">
        		<button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          			THÔNG TIN ĐẶT HÀNG
        		</button>
     			 </h5>
    		</div>

    		<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
      			<div class="card-body">
        			<div class="row">
        				<div class="col-md-2">
							<label>Họ và tên:</label>
						</div>
						<div class="col-md-4">
							<label>{{$tran_info->customer_name}}</label>
						</div>
						<div class="col-md-2">
							<label>Số điện thoại</label>
						</div>
						<div class="col-md-4">
							<label>{{$tran_info->customer_phone}}<label>
						</div>
        			</div>

        			<div class="row">
        				<div class="col-md-2">
							<label>Email:</label>
						</div>
						<div class="col-md-10">
							<label>{{$tran_info->customer_email}}</label>
						</div>
        			</div>

        			<div class="row">
        				<div class="col-md-2">
							<label>Địa chỉ:</label>
						</div>
						<div class="col-md-10">
							<label>{{$tran_info->delivery_address}}</label>
						</div>
        			</div>

        			<div class="row">
        				<div class="col-md-2">
							<label>Yêu cầu:</label>
						</div>
						<div class="col-md-10">
							@if(empty($tran_info->description))
							<label>Không có yêu cầu</label>
							@else
							<label>{{$tran_info->description}}</label>
							@endif
						</div>
        			</div>

      			</div>
    		</div>
  		</div>

  		<div class="card" style="margin-top: 20px">
    		<div class="card-header" id="headingTwo">
      			<h5 class="mb-0">
        		<button class="btn btn-link" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          			SẢN PHẨM ĐÃ MUA
        		</button>
     			 </h5>
    		</div>

    		<div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordion">
      			<div class="card-body">

      				<div class="row">
        				<div class="col-md-2">
							<label>Mã đơn hàng:</label>
						</div>
						<div class="col-md-4">
							<label>{{$tran_info->id}}</label>
						</div>
						<div class="col-md-2">
							<label>Trạng thái:</label>
						</div>
						<div class="col-md-4">
							<label>{{$tran_stt->name}}</label>
						</div>
        			</div>

        			<div class="row">
        				<div class="col-md-2">
							<label>Tổng tiền:</label>
						</div>
						<div class="col-md-4">
							<label>{{number_format($tran_info->total_amount,0,',','.')}} đ</label>
						</div>
						<div class="col-md-2">
							<label>Ngày tạo:</label>
						</div>
						<div class="col-md-4">
							<label>{{$tran_info->created_at}}</label>
						</div>
        			</div>

        			<table class="table table-striped" style="margin-top: 20px">
					  	<thead>
					    	<tr>
					      		<th scope="col">Tên sản phẩm</th>
					      		<th scope="col">Số lượng</th>
					      		<th scope="col">Tổng tiền</th>
					      		<th scope="col">Trạng thái</th>
					    	</tr>
					  	</thead>
					  	<tbody>
					  		@foreach($orders_info as $item)
					    	<tr>
					    		@if(strlen($item->product_name) < 50)
					    		<td>{{$item->product_name}}</td>
					    		@else
					    		<td>{{mb_substr($item->product_name,0,50)}}</td>
					    		@endif
					      		<td>{{$item->quantity}}</td>
					      		<td>{{number_format($item->amount,0,',','.')}} đ</td>
					      		<td>{{$item->status_name}}</td>
					    	</tr>
					    	@endforeach
					  	</tbody>
					</table>
      			</div>
    		</div>
  		</div>

		<a href="{{route('mainpage')}}"><button style="margin-top: 20px" type="button" class="btn btn-primary btn-lg btn-block">Tiếp tục mua hàng</button></a>
		@endif
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