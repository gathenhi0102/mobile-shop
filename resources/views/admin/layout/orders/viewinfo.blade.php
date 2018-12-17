@extends('admin.master')

@section('head')
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="source/images/o-ico.png">
    <base href="{{asset('')}}">

    <title>Xem thông tin đơn hàng</title>

    <!-- Bootstrap Core CSS -->
    <link href="admin_source/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="admin_source/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="admin_source/vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="admin_source/vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="admin_source/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="admin_source/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
@endsection

@section('content')

<!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Xem thông tin đơn hàng</h1>
                </div>
                    <!-- /.col-lg-12 -->
            </div>
                <!-- /.row -->
            @if(Session::has('flag'))
            <div class="row" style="margin-top: 20px">
                <div class="col-lg-12">    
                    <div class="alert alert-{{Session::get('flag')}}" role="alert" style="text-align: center; font-size: large;">{{Session::get('message')}}</div>
                </div>    
            </div>
            @endif

            <div class="row" style="margin-top: 20px">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Thông tin đơn hàng
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="col-xs-12 col-sm-12 col-md-12">

                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <label>Mã đơn hàng</label>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <p>{{$transaction_info->id}}</p>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                            <label>Trạng thái</label>
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <p>{{$transaction_info->stt_name}}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <label>Họ Tên khách hàng</label>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <p>{{$transaction_info->customer_name}}</p>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                            <label>Email khách hàng</label>
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <p>{{$transaction_info->customer_email}}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <label>Điện thoại</label>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <p>{{$transaction_info->customer_phone}}</p>
                                        </div>
                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                            <label>Ngày tạo</label>
                                        </div>
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <p>{{$transaction_info->created_at}}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <label>Địa chỉ</label>
                                        </div>
                                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                            <p>{{$transaction_info->delivery_address}}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <label>Mô tả</label>
                                        </div>
                                        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                                            <p>{{$transaction_info->description}}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <label>Số tiền thanh toán</label>
                                        </div>
                                        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                                            <p>{{number_format($transaction_info->total_amount,0,',','.')}} đ</p>
                                        </div>
                                        @if(!empty($status_img))
                                        <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                            <img src="source/images/{{$status_img}}.png">
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                
                                @if(empty($status_img))    
                                <form role = "form" method="post" action="{{route('updatetraninfo')}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="tran_id" value="{{$transaction_info->id}}">

                                <fieldset style="margin-top: 30px">
                                <legend>CẬP NHẬT ĐƠN HÀNG</legend>    
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Chọn sản phẩm</label>
                                            <select class="form-control" name="select_product">
                                                <option value="0" selected>Tất cả sản phẩm trong đơn hàng</option>
                                                @foreach($orders as $ods)
                                                <option value="{{$ods->id}}" @if(!empty($ods->disable)) disabled @endif>{{$ods->product_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                        
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Chọn trạng thái</label>
                                            <select class="form-control" name="update_stt_option">
                                                @foreach($list_stt as $stt)
                                                <option value="{{$stt->id}}" @if($transaction_info->status_id == $stt->id) selected @endif>{{$stt->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Ghi chú</label>
                                            <textarea class="form-control" rows="3" placeholder="Nhập ghi chú cho đơn hàng (ví dụ: Lý do hủy đơn hàng...)" name="orders_note">{{$transaction_info->note}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Cập nhật</button>
                                        </div>
                                    </div>
                                </div>
                                </fieldset>
                            </form>
                            @endif
                            </div>

                            @if(!empty($transaction_info->success))
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <a href="{{route('exportpdf', $transaction_info->id)}}">
                                            <button type="button" class="btn btn-primary btn-block">Xuất hóa đơn</button>
                                        </a>  
                                    </div>
                                </div>
                            @endif

                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
            </div>

            <div class="row" style="margin-top: 20px">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Danh sách sản phẩm
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover dataTables">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Số lượng</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày tạo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $item)
                                    <tr>
                                        <td>{{$item->id}}</td>
                                        @if(strlen($item->product_name) < 20)
                                        <td>{{$item->product_name}}</td>
                                        @else
                                        <td title="{{$item->product_name}}">{{mb_substr($item->product_name,0,17)}}...</td>
                                        @endif
                                        <td>{{$item->quantity}}</td>
                                        <td>{{number_format($item->amount,0,',','.')}} đ</td>
                                        <td><span class="label label-{{$item->status_color}}">{{$item->status_name}}</span></td>
                                        <td>{{$item->created_at}}</td>
                                    </tr>
                                    @endforeach    
                                </tbody>
                            </table>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
            </div>

        </div>
        <!-- /#page-wrapper -->
@endsection

@section('script')
<!-- jQuery -->
    <script src="admin_source/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="admin_source/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="admin_source/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="admin_source/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="admin_source/vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="admin_source/vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="admin_source/dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
@endsection