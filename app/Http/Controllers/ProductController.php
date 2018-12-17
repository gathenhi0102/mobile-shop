<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\TradeMark;
use App\Comment;
use App\User;

class ProductController extends Controller
{
    //lấy danh sách sản phẩm theo loại
    public function getEmptyProduct(){
        $product = Product::where('quantity',0)->get();
        return view('admin.layout.product.listview', compact('product'));
    }

    //sản phẩm
    public function product(Request $req){  
        $product_limit = 10;
        $user_default_image = 'default-user-icon.png';
        
        $product_inf = Product::where('id', $req->id)->first();
        if(empty($product_inf))
            return redirect()->route('mainpage');
        $category = Category::where('id', $product_inf->category_id)->first();
        $conditions_product = Product::where([['id','<>',$product_inf->id], ['category_id',$product_inf->category_id], ['trademark_id',$product_inf->trademark_id]]);
        $product_quantity = $conditions_product->count();
        if($product_quantity > $product_limit){
            $same_product = $conditions_product->take($product_limit)->get();
        }
        else{
            $same_product = $conditions_product->take($product_quantity)->get();
        }
        $product_feedback = Comment::where('product_id', $req->id)->orderBy('id', 'desc')->get();
        if(!$product_feedback->isEmpty()){
            foreach ($product_feedback as $cmt) {
                $user = User::where('id', $cmt->user_id)->first();
                if(empty($user))
                    $cmt->user_image = $user_default_image;
                else    
                    $cmt->user_image = $user->user_image;
            }
        }
        //cập nhật lại lượt xem
        $view = $product_inf->view_count;
        Product::where('id', $product_inf->id)->update(['view_count' => $view + 1]);     
    	return view('page.product', compact('product_inf', 'category','same_product','product_feedback'));
    }

    public function getSearch(Request $req){
        if(empty($req->category_selected)){
            $product = Product::where('name','like', '%'.$req->search.'%')->paginate(20);
            $trademark = TradeMark::all();
            return view('page.home',compact('trademark','product'));
        }
        $product = Product::where([['name','like', '%'.$req->search.'%'],['category_id',$req->category_selected]])->paginate(20);
        $trademark = TradeMark::all();
        return view('page.home',compact('trademark','product'));
    }

    //danh sách sản phẩm
    public function getListProduct(){
        $product = Product::all();
        return view('admin.layout.product.listview', compact('product'));
    }

    //thêm sản phẩm
    public function getInsertProduct(){
        $trademark = TradeMark::all();
        $category = Category::all();
        return view('admin.layout.product.insert', compact('trademark', 'category'));
    }

    public function postProductInfo(Request $req){
        if($req->isMethod('post')){
            $this->validate($req,
                [
                    'product_name' => 'required|min:4',
                    'product_price' =>'required|numeric',
                    'image' => 'image|mimes:jpeg,jpg,png,svg|max:2048',
                    'product_quantity' => 'required|numeric'
                ],

                [
                    'product_quantity.required' => 'Vui lòng nhập số lượng sản phẩm',
                    'product_quantity.numeric' => 'Số lượng sản phẩm phải là kiểu số',
                    'product_price.required' => 'Vui lòng nhập giá của sản phẩm',
                    'product_price.numeric' => 'Giá của sản phẩm phải là kiểu số',
                    'product_name.required' =>'Vui lòng nhập tên sản phẩm',
                    'product_name.min' =>'Tên sản phẩm phải có tối thiểu 4 ký tự',
                    'image.image' => 'Vui lòng chọn định dạng hình ảnh.',
                    'image.mimes' => 'Chỉ hỗ trợ định dạng: jpeg, jpg, png, svg',
                    'image.max' => 'Dung lượng tối đa là 2048kb',
                ]
            );

            if($req->hasFile('image')){
                $file = $req->file('image');
                $filename = $file->getClientOriginalName('image');
                $url = 'source/images';
                $file->move($url, $filename);
            }

            //get parameters
            $screen = $req->product_screen;
            $os = $req->product_os;
            $cpu = $req->product_cpu;
            $ram = $req->product_ram;
            $cam = $req->product_cam;
            $pin = $req->product_pin;

            $param_arr = array('Màn hình'=>$screen, 'Hệ điều hành' => $os, 'CPU' => $cpu, 'RAM' =>$ram, 'Camera' => $cam, 'Pin' => $pin);
            $parameters = json_encode($param_arr, JSON_UNESCAPED_UNICODE);

            if(empty($req->product_id)){
                $product = new Product();
                $message = 'THÊM SẢN PHẨM MỚI THÀNH CÔNG.';
            }
            else{
                $product = Product::find($req->product_id);
                if(empty($product))
                    return redirect()->route('listproduct')->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY THÔNG TIN SẢN PHẨM.']);
                $message = 'CHỈNH SỬA SẢN PHẨM THÀNH CÔNG.'; 
            }
            $product->name = $req->product_name;
            $product->category_id = $req->get('product_category');
            $product->trademark_id = $req->get('product_trademark');
            $product->original_price = $req->product_price;
            $product->quantity = $req->product_quantity;
            $product->description = $req->product_description;
            $product->parameters = $parameters;

            if($req->hasFile('image')){
                $product->main_image = strtolower($url."/".$filename);
            }

            $product->gift = $req->product_gift;
            $product->status = $req->get('product_status');

            if($product->save())
                return redirect()->back()->with(['flag' => 'success', 'message' => $message]);
            return redirect()->back()->with(['flag' => 'danger', 'message' => 'CÓ LỖI XẢY RA, VUI LÒNG THỬ LẠI']);
        }
        return redirect()->back()->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY PHƯƠNG THỨC POST.']);
    }

    //xóa sản phẩm
    public function getDeleteProduct($id){
        $product_info = Product::find($id);
        if(empty($product_info))
            return redirect()->route('listproduct')->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY THÔNG TIN CẦN XÓA.']);
        $product_info->delete();
        return redirect()->route('listproduct')->with(['flag' => 'success', 'message' => 'XÓA SẢN PHẨM THÀNH CÔNG.']);
    }

    //chỉnh sửa sản phẩm
    public function getEditProductInfo($id){
        $trademark = TradeMark::all();
        $category = Category::all();
        $product_info = Product::find($id);
        if(empty($product_info))
            return redirect()->route('listproduct')->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY THÔNG TIN.']);
        return view('admin.layout.product.edit', compact('trademark', 'category', 'product_info'));
    }
}
