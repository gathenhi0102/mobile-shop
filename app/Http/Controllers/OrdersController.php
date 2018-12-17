<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Orders;
use Auth;

class OrdersController extends Controller
{
    //hủy sản phẩm trong đơn hàng
    public function getCancelSubOrders($id){
    	$cancel_status = 12;
        $orders = Orders::find($id);
        if(Auth::check()){
            if(empty($orders))
                return redirect()->route('getorderinfo', ['order_email' => Auth::user()->email, 'order_phone' => Auth::user()->phone])->with(['flag' => 'danger', 'message' => 'Sản phẩm này không tồn tại.']);
            $check = 0;
            $tran = Transaction::where('customer_id',Auth::user()->id)->get();
            foreach ($tran as $item) {
            	if($item->id == $orders->transaction_id)
            		$check++;
            }
            if($check == 0)
            	 return redirect()->route('getorderinfo', ['order_email' => Auth::user()->email, 'order_phone' => Auth::user()->phone])->with(['flag' => 'danger', 'message' => 'Sản phẩm này không thuộc đơn hàng nào của bạn.']);

            $effected_row = Orders::where('id', $orders->id)->update(['status_id' => $cancel_status]);
            if($effected_row == 0)
            	return redirect()->route('getorderinfo', ['order_email' => Auth::user()->email, 'order_phone' => Auth::user()->phone])->with(['flag' => 'danger', 'message' => 'Hủy đơn hàng thất bại, vui lòng thử lại.']);

            //cập nhật lại tổng tiền
            $order_tran = Transaction::where('id', $orders->transaction_id)->first();
            $total = $order_tran->total_amount;
            $update_total = $total - $orders->amount;
            if($update_total==0){
            	Transaction::where('id', $orders->transaction_id)->update(['total_amount' => $update_total, 'status_id' => $cancel_status]);
            	return redirect()->route('getorderinfo', ['order_email' => Auth::user()->email, 'order_phone' => Auth::user()->phone])->with(['flag' => 'success', 'message' => 'Hủy sản phẩm thành công.']);
            }

            Transaction::where('id', $orders->transaction_id)->update(['total_amount' => $update_total]);
            return redirect()->route('getorderinfo', ['order_email' => Auth::user()->email, 'order_phone' => Auth::user()->phone])->with(['flag' => 'success', 'message' => 'Hủy sản phẩm thành công.']);                                
        }
        return redirect()->route('loginpage')->with(['flag' => 'danger', 'message' => 'Bạn phải đăng nhập trước khi sử dụng chức năng này.']);
    }
}
