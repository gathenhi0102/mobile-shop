<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Cart;
use App\Transaction;
use App\Orders;
use App\Status;
use App\Product;
use Auth;

class ContactController extends Controller
{
    //nếu đơn hàng <5tr thì phí là 2%
    protected $fee_percent = 0.02;
    protected $empty_note = 'Không có ghi chú gì.';
    //đặt hàng
    public function contact(){
    	$total_item = Cart::count();
        if(empty($total_item))
            return redirect()->route('mainpage');
        $total_price = Cart::subtotal(0);
        $total_price = (int)str_replace(",","",$total_price);
        $cart = Cart::content();
        return view('page.contact', compact('total_item', 'total_price', 'cart'));
    }

    //lưu hóa đơn
    public function postOrders(Request $req){
        if(empty(Cart::count()))
            return redirect()->route('mainpage');
            
        $total_price = Cart::subtotal(0);
        $total_price = (int)str_replace(",","",$total_price);
        $cart = Cart::content();
        $tran_fee = 0;
        if($total_price < 5000000){
            $tran_fee = $total_price*$this->fee_percent;
        }

        $tran = new Transaction;
        if(Auth::check()){
            $tran->customer_id = Auth::user()->id;
        }
        $tran->customer_name = $req->contact_form_name;
        $tran->customer_email = $req->contact_form_email;
        $tran->customer_phone = $req->contact_form_phone;
        $tran->delivery_address = $req->contact_form_address;
        $tran->description = $req->contact_form_description;
        $tran->total_amount = $total_price + $tran_fee;
        $tran->transport_fee = $tran_fee;
        $status = 0;
        if($tran->save()){
            foreach ($cart as $item) {
                $order = new Orders;
                $order->transaction_id = $tran->id;
                $order->product_id = $item->id;
                $order->quantity = $item->qty;
                $order->amount = $item->qty*$item->price;
                $order->save();
            }
            $status = 1;
            Cart::destroy();
            return redirect()->route('review',['id' => $tran->id, 'status' => $status]);
        }

        return redirect()->route('review',['status' => $status]);
    }

    public function reviewOrders(Request $req){
        $tranid = $req->get('id');
        $status = $req->get('status');
        if(empty($tranid))
            return view('page.ordersstatus', compact('status'));
        $tran_info = Transaction::where('id', $tranid)->first();
        $tran_stt = Status::where('id', $tran_info->status_id)->first();
        $orders_info = Orders::where('transaction_id', $tranid)->get();
        foreach ($orders_info as $item) {
            $product = Product::where('id', $item->product_id)->first();
            $order_stt = Status::where('id', $item->status_id)->first();
            $item->product_name = $product->name;
            $item->status_name = $order_stt->name;
        }
        $vars = array('tran_info','orders_info','status','tran_stt');
        return view('page.ordersstatus', compact($vars));
    }

    public function getInputOrderInfo(){
        return view('page.inputorderinfo');
    }

    //post để lấy thông tin đơn hàng
    public function getOrderInfo(Request $req){
        $customer_email = $req->order_email;
        $customer_phone = $req->order_phone;
        $tran_data = Transaction::where([['customer_email', $customer_email],['customer_phone', $customer_phone]])->orderBy('id', 'desc')->paginate(5);
        if($tran_data->isEmpty())
            return redirect()->route('inputorderinfo')->with('message','Không tìm thấy thông tin đơn hàng.');

        //lấy trạng thái đơn hàng và danh sách các chi tiết đơn hàng
        foreach ($tran_data as $item){

            $tran_stt = Status::where('id', $item->status_id)->first();
            $item->status_name = $tran_stt->name;
            if(empty($item->note))
                $item->note = $this->empty_note;
            $orders_info = Orders::where('transaction_id', $item->id)->get();
            $item->listmembers = $orders_info;

            //lấy trạng thái và tên sản phẩm trong chi tiết đơn hàng
            foreach ($item->listmembers as $member) {
                $orders_stt = Status::where('id', $member->status_id)->first();
                $product = Product::where('id', $member->product_id)->first();
                $member->orders_stt = $orders_stt->name;
                $member->product_name = $product->name;
            }
        }
        //phân trang
        $tran_data = $tran_data->appends(Input::except('page'));

        return view('page.orderinfo',compact('tran_data'));
    }
}
