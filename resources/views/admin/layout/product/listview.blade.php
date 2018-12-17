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

    <title>Danh sách sản phẩm</title>

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
                    <h1 class="page-header">Quản lý sản phẩm</h1>
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
                
            <div class="row">
                <div class="col-lg-12">
                    <a href="{{route('addproduct')}}" type="button" class="btn btn-primary">THÊM SẢN PHẨM</a>
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
                                        <th>Tên</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Lượt mua</th>
                                        <th>Lượt xem</th>
                                        <th style="width: 12%">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product as $item)
                                    <tr>
                                        <td><a role = "button" href="{{route('editproduct',$item->id)}}">{{$item->id}}</a></td>
                                        @if(strlen($item->name) < 20)
                                        <td>{{$item->name}}</td>
                                        @else
                                        <td title="{{$item->name}}">{{mb_substr($item->name,0,17)}}...</td>
                                        @endif
                                        <td>{{number_format($item->original_price,0,',','.')}} đ</td>
                                        <td>{{$item->quantity}}</td>
                                        <td>{{$item->buy_count}}</td>
                                        <td>{{$item->view_count}}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><span class="caret"></span></button>
                                                <ul class="dropdown-menu dropdown-content pull-right">
                                                    <li><a role = "button" href="{{route('editproduct',$item->id)}}"><i class="glyphicon glyphicon-edit"></i> Sửa</a></li>
                                                    <li><a href="{{route('deleteproduct', $item->id)}}" role = "button" class="deletetrademark"><i class="glyphicon glyphicon-remove"></i> Xóa</a></li>
                                                </ul>
                                            </div>
                                        </td>
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