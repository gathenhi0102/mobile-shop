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

    <title>Xem và chỉnh sửa trạng thái</title>

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
</head>
@endsection

@section('content')
<!-- Page Content -->
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Xem và chỉnh sửa thông tin.</h1>
                </div>
                    <!-- /.col-lg-12 -->
            </div>
                <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    @if(Session::has('flag'))
                    <div class="alert alert-{{Session::get('flag')}}" role="alert" style="text-align: center; font-size: large;">{{Session::get('message')}}</div>
                    @endif
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Thông tin của trạng thái
                        </div>
                        <div class="panel-body">
                            @if(count($errors) > 0)
                            <div class="alert alert-danger" role="alert">
                            @foreach($errors->all() as $err)
                                {{$err}}<br>
                            @endforeach
                            </div>
                            @endif
                            <form role="form" action="{{route('postorderstatusinfo')}}" method="post">
                            <fieldset>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" name="orderstatus_id" value="{{$status_info->id}}">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Tên trạng thái</label>
                                            <input class="form-control" name="orderstatus_name" placeholder="Nhập tên trạng thái đơn hàng" required value="{{$status_info->name}}">
                                        </div>  
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Mô tả</label>
                                            <textarea name="orderstatus_description" class="form-control" rows="3">{{$status_info->description}}</textarea>
                                        </div>  
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Sửa</button>
                                <a href="{{route('getlistorderstatus')}}" type="button" role = "button" class="btn btn-danger">Thoát</a>
                            </fieldset>    
                            </form>        
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

    <!-- Custom Theme JavaScript -->
    <script src="admin_source/dist/js/sb-admin-2.js"></script>
@endsection