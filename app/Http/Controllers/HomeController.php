<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TradeMark;
use App\Product;
use App\Category;
use App\User;
use App\Transaction;
use App\Comment;

class HomeController extends Controller
{
    //trang chủ
    public function index(){
        $trademark = TradeMark::all();
        $product = Product::where('category_id', 1)->paginate(20);
        return view('page.home',compact('trademark', 'product'));
    }

    //lấy sản phẩm theo thương hiệu
    public function getProductsByTrademark($trademark){
        $product = Product::where('trademark_id', $trademark)->orderBy('id', 'desc')->paginate(20);
        $trademark = TradeMark::all();
        return view('page.home',compact('trademark','product'));
    }

    //lấy sản phẩm theo loại sản phẩm
     public function getProductsByType($type){
        $product = Product::where('category_id', $type)->paginate(20);
        $trademark = TradeMark::all();
        return view('page.home',compact('trademark','product'));
    }

    //phần giao diện admin
    public function adminIndex(){
        $newstatus = 1;
        $user_cancel = 12;
        $system_cancel = 13;
        $transfer_stt = 9;
        $success_stt = 10;
        $returning_stt = 15;

        $new_user = User::where([ ['type', $newstatus],['user_level', 0],['point', 0] ])->count();
        $new_order = Transaction::where('status_id', $newstatus)->count();
        $empty_product = Product::where('quantity', 0)->count();
        $cancel_order = Transaction::whereBetween('status_id', array($user_cancel, $system_cancel))->count();
        $transfer_orders = Transaction::where('status_id', $transfer_stt)->count();
        $success_order = Transaction::where('status_id', $success_stt)->count();
        $return_order = Transaction::where('status_id', $returning_stt)->count();

        //tính doanh thu trong ngày
        $today = date("Y-m-d");
        $today_total = 0;
        $orders = Transaction::where('status_id',$success_stt)->get();
        foreach ($orders as $item) {
            $order_date = $item->updated_at->format("Y-m-d");
            if($order_date==$today)
                $today_total = $today_total+$item->total_amount;
        }

        //tính comment mới nhất
        $cmt_total = 0;
        $comment = Comment::all();
        foreach ($comment as $cmt) {
            $cmt_date = $cmt->created_at->format("Y-m-d");
            if($cmt_date==$today)
                $cmt_total++;
        }
        
        $val = array('new_user', 'new_order', 'empty_product', 'cancel_order', 'transfer_orders', 'success_order', 'today_total', 'cmt_total', 'return_order');
        return view('admin.layout.index', compact($val));
    }
}
