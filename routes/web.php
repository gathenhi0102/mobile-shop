<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*
|--------------------------------------------------------------------------
| Customer Page route
|--------------------------------------------------------------------------
|
*/

Route::get('/',['as' => 'indexpage','uses'=>'HomeController@index']);

//route trang chủ
Route::get('index',['as' => 'mainpage', 'uses'=>'HomeController@index']);

//route sản phẩm
Route::get('product/{id}',['as' => 'productpage', 'uses'=>'ProductController@product']);

//lấy sản phẩm theo thương hiệu(trademark)
Route::get('trademark/{trademarkid}',['as' => 'producttrademark', 'uses'=>'HomeController@getProductsByTrademark']);

//lấy sản phẩm theo loại(category)
Route::get('category/{categoryid}',['as' => 'productcategory', 'uses'=>'HomeController@getProductsByType']);

//route giỏ hàng
//thêm sản phẩm vào giỏ hàng
Route::post('addtocart',['as' => 'addtocart', 'uses'=>'CartController@addToCart']);

//lấy thông tin giỏ hàng
Route::get('cartinfo',['as' => 'cartinfo', 'uses'=>'CartController@getCart']);

//xóa sản phẩm trong giỏ hàng
Route::get('deletecart/{id}',['as' => 'delcart', 'uses' => 'CartController@delCart']);

//route đặt hàng
Route::get('contact',['as' => 'contactpage', 'uses'=>'ContactController@contact']);

//lưu thông tin đặt hàng
Route::post('orders',['as' => 'orders', 'uses'=>'ContactController@postOrders']);

//xem lại đơn hàng
Route::get('review',['as' => 'review', 'uses'=>'ContactController@reviewOrders']);

//hiển thị form đăng nhập
Route::get('login',['as' => 'loginpage', 'uses'=>'UserController@login']);

//đăng nhập vào hệ thống
Route::post('postlogin',['as' => 'postlogin', 'uses'=>'UserController@postLogin']);

//đăng ký
Route::get('register',['as' => 'registerpage', 'uses'=>'UserController@register']);

//lưu thông tin đăng kí
Route::post('saveinfo',['as' => 'saveregisterinfo', 'uses'=>'UserController@saveRegisterInfo']);

//tìm kiếm
Route::get('search',['as' => 'search', 'uses'=>'ProductController@getSearch']);

//xem đơn hàng
Route::get('inputorderinfo',['as' => 'inputorderinfo', 'uses'=>'ContactController@getInputOrderInfo']);

//get lấy thông tin đơn hàng
Route::get('getorderinfo',['as' => 'getorderinfo', 'uses'=>'ContactController@getOrderInfo']);

//đăng xuất
Route::get('logout',['as' => 'logout', 'uses'=>'UserController@Logout']);

//xem thông tin cá nhân
Route::get('userprofile/{customerid}',['as' => 'userprofile', 'uses'=>'UserController@getUserProfile']);

//chỉnh sửa thông tin cá nhân
Route::get('edituserprofile/{customerid}',['as' => 'edituserprofile', 'uses'=>'UserController@editUserProfile']);

//phản hồi
Route::post('postcomment',['as' => 'postcomment', 'uses'=>'CommentController@postComment']);

//lưu thông tin cá nhân
Route::post('saveprofile/{id}',['as' => 'saveprofile', 'uses'=>'UserController@saveUserProfile']);

//Hủy đơn hàng
Route::get('cancelorder/{id}',['as' => 'cancelorder', 'uses'=>'TransactionController@getCancelOrder']);

//hủy chi tiết đơn hàng
Route::get('cancelsuborders/{id}',['as' => 'cancelsuborders', 'uses'=>'OrdersController@getCancelSubOrders']);

//lấy lại mật khẩu
Route::post('ajaxpostuserprofile',['as' => 'ajaxpostuserprofile', 'uses'=>'UserController@postUserProfileAjax']);

// load trang đổi mật khẩu
Route::get('changepassword',['as' => 'changepassword', 'uses'=>'UserController@getChangePassword']);

//post đổi mật khẩu
Route::post('postchangepasswordinfo/{id}',['as' => 'postchangepasswordinfo', 'uses'=>'UserController@postChangePasswordInfo']);

//test
//Route::get('test/{id}',['as' => 'test', 'uses'=>'CartController@test']);
/*
|--------------------------------------------------------------------------
| Admin Page route
|--------------------------------------------------------------------------
|
*/

//load giao diện admin
Route::get('admin/login',['as' => 'adminlogin', 'uses'=>'UserController@adminLogin']);
Route::post('admin/login',['as' => 'postadminlogin', 'uses'=>'UserController@postAdminLoginInfo']);

//Tạo route group
Route::group(['prefix' => 'admin', 'middleware' => 'adminLogin'], function(){

	//hiện giao diện trang chủ
	Route::get('index',['as' => 'index','uses'=>'HomeController@adminIndex']);
	//đăng xuất
	Route::get('adminlogout',['as' => 'adminlogout', 'uses'=>'UserController@adminLogout']);

	//thương hiệu
	Route::group(['prefix' => 'trademark'], function(){
		// admin/trademark/list

		//hiển thị danh sách
		Route::get('listtrademark',['as' => 'listtrademark', 'uses'=>'TrademarkController@getListTrademark']);

		//thêm mới
		Route::get('addtrademark',['as' => 'addtrademark', 'uses'=>'TrademarkController@getInsertTrademark']);
		Route::post('posttrademarkinfo',['as' => 'posttrademarkinfo', 'uses'=>'TrademarkController@postTrademarkInfo']);

		//sửa
		Route::get('edittrademark/{id}',['as' => 'edittrademark', 'uses'=>'TrademarkController@getEditTrademarkInfo']);

		//xóa
		Route::get('deletetrademark/{id}',['as' => 'deletetrademark', 'uses'=>'TrademarkController@getDeleteTrademark']);
	});

	//thể loại
	Route::group(['prefix' => 'category'], function(){
		// admin/category/list
		//xem danh sách
		Route::get('listcategory',['as' => 'listcategory', 'uses'=>'CategoryController@getListCategory']);

		//thêm thể loại
		Route::get('addcategory',['as' => 'addcategory', 'uses'=>'CategoryController@getInsertCategory']);
		Route::post('postcategoryinfo',['as' => 'postcategoryinfo', 'uses'=>'CategoryController@postCategoryInfo']);

		//chỉnh sửa thể loại
		Route::get('editcategory/{id}',['as' => 'editcategory', 'uses'=>'CategoryController@getEditCategoryInfo']);

		//xóa thể loại
		Route::get('deletecategory/{id}',['as' => 'deletecategory', 'uses'=>'CategoryController@getDeleteCategory']);
	});

	//trạng thái đơn hàng

	Route::group(['prefix' => 'status'], function(){

		//danh sách trạng thái
		Route::get('getlistorderstatus',['as' => 'getlistorderstatus', 'uses'=>'OrderTypeController@getListOrderStatus']);

		//thêm trạng thái mới
		Route::get('addorderstatus',['as' => 'addorderstatus', 'uses'=>'OrderTypeController@getInsertStatus']);
		Route::post('postorderstatusinfo',['as' => 'postorderstatusinfo', 'uses'=>'OrderTypeController@postOrderStatusInfo']);

		//xóa trạng thái
		Route::get('deletestatus/{id}',['as' => 'deletestatus', 'uses'=>'OrderTypeController@getDeleteOrderStatus']);

		//sửa trạng thái
		Route::get('editstatus/{id}',['as' => 'editstatus', 'uses'=>'OrderTypeController@getEditStatusInfo']);
	});

	//sản phẩm
	Route::group(['prefix' => 'product'], function(){
		//xem danh sách
		Route::get('listproduct',['as' => 'listproduct', 'uses'=>'ProductController@getListProduct']);

		//thêm sản phẩm
		Route::get('addproduct',['as' => 'addproduct', 'uses'=>'ProductController@getInsertProduct']);
		Route::post('postproductinfo',['as' => 'postproductinfo', 'uses'=>'ProductController@postProductInfo']);

		//xóa sản phẩm
		Route::get('deleteproduct/{id}',['as' => 'deleteproduct', 'uses'=>'ProductController@getDeleteProduct']);

		//lọc sản phẩm đã hết
		Route::get('getemptyproduct',['as' => 'getemptyproduct', 'uses'=>'ProductController@getEmptyProduct']);

		//chỉnh sửa sản phẩm
		Route::get('editproduct/{id}',['as' => 'editproduct', 'uses'=>'ProductController@getEditProductInfo']);
	});

	//đơn hàng
	Route::group(['prefix' => 'transaction'], function(){

		//lọc đơn hàng theo loại
		Route::get('getbystatus/{stt}',['as' => 'getbystatus', 'uses'=>'TransactionController@getTransactionByStatus']);

		//xem doanh thu trong ngày
		Route::get('viewrevenue',['as' => 'viewrevenue', 'uses'=>'TransactionController@ViewRevenue']);

		//xem danh sách
		Route::get('listtransactions',['as' => 'listtransactions', 'uses'=>'TransactionController@getListTransaction']);

		//xem thông tin
		Route::get('viewtraninfo/{id}',['as' => 'viewtraninfo', 'uses'=>'TransactionController@viewTransactionInfo']);

		//cập nhật trạng thái đơn hàng
		Route::post('updatetraninfo',['as' => 'updatetraninfo', 'uses' =>'TransactionController@updateTransactionInfo']);

		//xuất hóa đơn
		Route::get('exportpdf/{id}',['as' => 'exportpdf', 'uses'=>'TransactionController@exportInvoice']);
	});

	//khách hàng
	Route::group(['prefix' => 'user'], function(){

		//lấy danh sách
		Route::get('getlistusers/{usertype}',['as' => 'getlistusers', 'uses'=>'UserController@getListUsers']);

		//thêm admin
		Route::get('addnewadmin',['as' => 'addnewadmin', 'uses'=>'UserController@getAddNewAdmin']);
		Route::post('postadmininfo',['as' => 'postadmininfo', 'uses'=>'UserController@postAdminInfo']);

		//chỉnh sửa thông tin
		Route::get('editadmininfo/{id}',['as' => 'editadmininfo', 'uses'=>'UserController@getEditAdminInfo']);
		Route::post('posteditadmininfo/{id}',['as' => 'posteditadmininfo', 'uses'=>'UserController@postEditAdminInfo']);
	});

});



