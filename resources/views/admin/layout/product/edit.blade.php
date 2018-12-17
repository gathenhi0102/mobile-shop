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

    <title>Xem và chỉnh sửa thông tin sản phẩm</title>

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
<?php
$param = $product_info->parameters;
$param = json_decode($param, true);
$param_value = array_values($param);
?>
<!-- Page Content -->
        <div id="page-wrapper">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Xem và chỉnh sửa thông tin sản phẩm.</h1>
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
                            Thông tin của sản phẩm
                        </div>
                        <div class="panel-body">
                            @if(count($errors) > 0)
                            <div class="alert alert-danger" role="alert">
                            @foreach($errors->all() as $err)
                                {{$err}}<br>
                            @endforeach
                            </div>
                            @endif
                            <form role="form" action="{{route('postproductinfo')}}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" name="product_id" value="{{$product_info->id}}">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Tên sản phẩm</label>
                                            <input class="form-control" name="product_name" placeholder="Nhập tên sản phẩm" required value="{{$product_info->name}}">
                                        </div>  
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Giá sản phẩm</label>
                                            <input id="product_price" class="form-control" name="product_price" placeholder="Nhập giá của sản phẩm" required maxlength="11" value="{{$product_info->original_price}}">
                                        </div>    
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Chọn thương hiệu</label>
                                            <select class="form-control" name="product_trademark">
                                                @foreach($trademark as $trade)
                                                <option value="{{$trade->id}}" @if($trade->id == $product_info->trademark_id) selected @endif>{{$trade->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>  
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Chọn thể loại</label>
                                            <select class="form-control" name="product_category">
                                                @foreach($category as $cate)
                                                <option value="{{$cate->id}}" @if($cate->id == $product_info->category_id) selected @endif>{{$cate->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>  
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Mô tả cho sản phẩm</label>
                                            <textarea class="form-control" rows="3" placeholder="Nhập mô tả cho sản phẩm" name="product_description">{{$product_info->description}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Quà tặng</label>
                                            <input class="form-control" placeholder="Nhập quà tặng kèm sản phẩm" name="product_gift" value="{{$product_info->gift}}">
                                        </div>   
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Trạng thái sản phẩm</label>
                                            <select class="form-control" name="product_status">
                                                <option value="1" @if($product_info->status == 1) selected @endif>Mới</option>
                                                <option value="2" @if($product_info->status == 2) selected @endif>Cũ</option>
                                            </select>
                                        </div>  
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Số lượng</label>
                                            <input class="form-control" placeholder="Nhập số lượng của sản phẩm" name="product_quantity" id="product_quantity" maxlength="2" required value="{{$product_info->quantity}}">
                                        </div>   
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Thông số cho sản phẩm</label>
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th width="5%" style="text-align: center;">STT</th>
                                                        <th width="35%" style="text-align: center;">Thuộc tính</th>
                                                        <th style="text-align: center;">Giá trị</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>Màn hình</td>
                                                        <td><input type="text" class="form-control inputtable" name="product_screen" value="{{$param_value[0]}}"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>2</td>
                                                        <td>Hệ điều hành</td>
                                                        <td><input type="text" class="form-control inputtable" name="product_os" value="{{$param_value[1]}}"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>3</td>
                                                        <td>CPU</td>
                                                        <td><input type="text" class="form-control inputtable" name="product_cpu" value="{{$param_value[2]}}"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>4</td>
                                                        <td>RAM</td>
                                                        <td><input type="text" class="form-control inputtable" name="product_ram" value="{{$param_value[3]}}"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>5</td>
                                                        <td>Camera</td>
                                                        <td><input type="text" class="form-control inputtable" name="product_cam" value="{{$param_value[4]}}"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>6</td>
                                                        <td>Pin</td>
                                                        <td><input type="text" class="form-control inputtable" name="product_pin" value="{{$param_value[5]}}"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Chọn hình ảnh cho sản phẩm</label>
                                            <input type="file" name="image">
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Sửa</button>
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

    <script type="text/javascript">
        $("#product_price").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                 // Allow: Ctrl+A, Command+A
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
                 // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                     // let it happen, don't do anything
                     return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

        $("#product_quantity").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                 // Allow: Ctrl+A, Command+A
                (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
                 // Allow: home, end, left, right, down, up
                (e.keyCode >= 35 && e.keyCode <= 40)) {
                     // let it happen, don't do anything
                     return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });

    </script>
@endsection