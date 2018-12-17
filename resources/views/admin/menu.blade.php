<?php
    $customer = 0;
    $admin = 1;
?>

<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                            <!-- /input-group -->
            </li>

            <li>
                <a href="{{route('index')}}"><i class="fa fa-home"></i> Trang chủ</a>
            </li>

            <li>
                <a href="{{route('listtrademark')}}"><i class="fa fa-apple"></i> Thương hiệu</a>
            </li>

            <li>
                <a href="{{route('listcategory')}}"><i class="fa fa-calendar-o"></i> Thể loại</a>
            </li>

            <li>
                <a href="{{route('listtransactions')}}"><i class="fa fa-shopping-cart"></i> Đơn hàng</a>
            </li>

            <li>
                <a href="{{route('getlistorderstatus')}}"><i class="fa fa-edit"></i> Trạng thái đơn hàng</a>
            </li>

            <li>
                <a href="#"><i class="fa fa-users"></i> Người dùng<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{route('getlistusers', $customer)}}">Khách hàng</a>
                    </li>
                    <li>
                        <a href="{{route('getlistusers', $admin)}}">Quản trị viên</a>
                    </li>
                </ul>    
            </li>

            <li>
                <a href=""><i class="fa fa-user"></i> Trạng thái khách hàng</a>
            </li>

            <li>
                <a href="{{route('listproduct')}}"><i class="fa fa-laptop"></i> Sản phẩm</a>
            </li>

            <li>
                <a href=""><i class="fa fa-photo"></i> Hình ảnh sản phẩm</a>
            </li>

            <li>
                <a href=""><i class="fa fa-comment"></i> Phản hồi</a>
            </li>

            <li>
                <a href=""><i class="fa fa-heart"></i> Yêu thích</a>
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->