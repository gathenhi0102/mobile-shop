@extends('admin.master')

@section('head')
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="source/images/o-ico.png">
	<base href="{{asset('')}}">
    <title>Admin-Trang chủ</title>

    <!-- Bootstrap Core CSS -->
    <link href="admin_source/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="admin_source/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

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
@endsection

@section('content')

{{-- các trạng thái của đươn hàng theo id status database--}}
<?php
    $new_stt = 1;//đơn hàng mới
    $transfer_refund = 15;//chuyển hoàn
    $transporting = 9;//đang chuyển
    $cancel = 12;//khách hàng hủy
    $success = 10;//thành công
?>
<!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Trang chủ</h1>
                </div>
                    <!-- /.col-lg-12 -->
            </div>
                <!-- /.row -->

            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-dollar fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{number_format($today_total,0,',','.')}} đ</div>
                                    <div>Doanh thu của ngày hôm nay ( {{date("Y-m-d")}} )</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('viewrevenue')}}">
                            <div class="panel-footer">
                                <span class="pull-left">Xem Chi Tiết</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>  

            <div class="row">

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-shopping-cart fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$new_order}}</div>
                                    <div>Đơn hàng mới</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('getbystatus', $new_stt)}}">
                            <div class="panel-footer">
                                <span class="pull-left">Xem Chi Tiết</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-comments fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$cmt_total}}</div>
                                    <div>Phản hồi mới</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Xem Chi Tiết</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$new_user}}</div>
                                    <div>Khách hàng mới</div>
                                </div>
                            </div>
                        </div>
                        <a href="#">
                            <div class="panel-footer">
                                <span class="pull-left">Xem Chi Tiết</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-default" style="border-color: #333">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-refresh fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$return_order}}</div>
                                    <div>Hàng chuyển hoàn</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('getbystatus', $transfer_refund)}}">
                            <div class="panel-footer">
                                <span class="pull-left" style="color: #333">Xem Chi Tiết</span>
                                <span class="pull-right" style="color: #333"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>


            </div>

            <div class="row">

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-truck fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$transfer_orders}}</div>
                                    <div>Đang chuyển</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('getbystatus', $transporting)}}">
                            <div class="panel-footer">
                                <span class="pull-left">Xem Chi Tiết</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-danger" style="border-color: #d9534f">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-trash-o fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$cancel_order}}</div>
                                    <div>Đơn hàng bị hủy</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('getbystatus', $cancel)}}">
                            <div class="panel-footer">
                                <span class="pull-left" style="color: #d9534f">Xem Chi Tiết</span>
                                <span class="pull-right" style="color: #d9534f"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-success" style="border-color: #5cb85c">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-check fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$success_order}}</div>
                                    <div>Đơn hàng thành công</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('getbystatus', $success)}}">
                            <div class="panel-footer">
                                <span class="pull-left" style="color: #5cb85c">Xem Chi Tiết</span>
                                <span class="pull-right" style="color: #5cb85c"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-laptop fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge">{{$empty_product}}</div>
                                    <div>Sản phẩm đã hết!</div>
                                </div>
                            </div>
                        </div>
                        <a href="{{route('getemptyproduct')}}">
                            <div class="panel-footer">
                                <span class="pull-left">Xem Chi Tiết</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>    
        </div>
@endsection

@section('script')
<!-- jQuery -->
    <script src="admin_source/vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="admin_source/vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="admin_source/vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="admin_source/dist/js/sb-admin-2.js"></script>
@endsection
