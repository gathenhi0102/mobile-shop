<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Status;
use App\Orders;
use App\Product;
use Auth;
use App\User;
use App\UserType;
use PDF;
class TransactionController extends Controller
{
    protected $status_err = 'N/A';
    protected $user_cancel_status = 12;
    protected $system_cancel_status = 13;
    protected $return_status = 16;
    protected $success_stt = 10;
    protected $transfer_stt = 9;
    protected $empty_notification = 'Không có';
    protected $export_stt_arr = array(9,10);

    //status code array
    protected $return_transfer = array(12, 13, 16);
    protected $cancel_status_arr = array(12, 13);
    protected $fail_arr = array(11, 12, 13, 14, 15, 16);
    protected $finish_stt_arr = array(10, 12, 13, 16);  

    //lấy màu sắc theo trạng thái
    public function getColorbyStatus($status){
        switch ($status) {
            case 1:
            case 2:
            case 3:
                $stamp = 'primary';
                break;
            case 4:
            case 5:
            case 6:
            case 7:
                $stamp = 'info';
                break;
            case 8:
            case 9:
            case 10:
                $stamp = 'success';
                break;
            case 11:
            case 12:
            case 13:
                $stamp = 'danger';
                break;
            case 14:
            case 15:
            case 16:
                $stamp = 'warning';
                break;      
            default:
                $stamp = 'default';
                break;
        }
        return $stamp;
    }

    //xem danh sách các đơn hàng theo loại

    public function getTransactionByStatus($stt){
        $transaction = Transaction::where('status_id', $stt)->get();
        if(!$transaction->isEmpty()){
            foreach ($transaction as $tran) {
                $status = Status::where('id', $tran->status_id)->first();
                if(empty($status))
                    $tran->stt_name = $this->status_err;
                else{
                    $tran->stt_name = $status->name;
                    $tran->stt_color = $this->getColorbyStatus($status->id);
                }
            }
            return view('admin.layout.orders.listview', compact('transaction'));
        }
        return redirect()->route('listtransactions')->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY THÔNG TIN.']);
    }

    //xem doanh thu trong ngày
    public function ViewRevenue(){
        //tính doanh thu trong ngày
        $today = date("Y-m-d");
        $transaction = array();

        $list_orders = Transaction::where('status_id',$this->success_stt)->get();
        foreach ($list_orders as $item) {
            $order_date = $item->updated_at->format("Y-m-d");
            if($order_date==$today){
                $item->stt_name = 'Thành công';
                array_push($transaction, $item);
            }
        }
        return view('admin.layout.orders.listview', compact('transaction'));
    }

    //lấy danh sách tất cả đơn hàng
    public function getListTransaction(){
    	$transaction = Transaction::all();
    	if(!$transaction->isEmpty()){
    		foreach ($transaction as $tran) {
    			$status = Status::where('id', $tran->status_id)->first();
    			if(empty($status))
    				$tran->stt_name = $this->status_err;
    			else{
    				$tran->stt_name = $status->name;
                    $tran->stt_color = $this->getColorbyStatus($status->id);
                }
    		}
    		return view('admin.layout.orders.listview', compact('transaction'));
    	}
    	return redirect()->route('listtransactions')->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY THÔNG TIN.']);
    }

    //xem chi tiết đơn hàng
    public function viewTransactionInfo(Request $req){
    	$transaction_info = Transaction::find($req->id);

    	if(!empty($transaction_info)){

            $list_stt = Status::all();

    		$status = Status::where('id', $transaction_info->status_id)->first();
    		if(empty($status)){
    			$transaction_info->stt_name = $this->status_err;
    		}
    		else{
    			$transaction_info->stt_name = $status->name;
    		}

    		if(empty($transaction_info->description)){
    			$transaction_info->description = $this->empty_notification;
    		}

            if(empty($transaction_info->note)){
                $transaction_info->note = $this->empty_notification;
            }

            if($status->id==$this->success_stt){
                $status_img = 'success';
            }

            if(in_array($status->id, $this->cancel_status_arr))
                $status_img = 'cancelled';

            if($status->id==$this->return_status)
                $status_img = 'return';

            if(in_array($status->id, $this->export_stt_arr)){
                 $transaction_info->success = 1;
            }

    		$orders = Orders::where('transaction_id', $transaction_info->id)->get();
    		foreach ($orders as $od) {
    			$product = Product::where('id', $od->product_id)->first();
    			$status = Status::where('id', $od->status_id)->first();
    			$od->product_name = $product->name;
    			$od->status_name = $status->name;
                if(in_array($od->status_id, $this->finish_stt_arr))
                    $od->disable = 1;
                $od->status_color = $this->getColorbyStatus($status->id);	
    		}

    		return view('admin.layout.orders.viewinfo', compact('transaction_info', 'orders', 'list_stt', 'status_img'));
    	}
        //nếu đơn hàng không tồn tại
    	return redirect()->route('listtransactions')->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY THÔNG TIN.']);	
    }

    //khách hàng hủy đơn hàng
    
    public function getCancelOrder($id){
        $tran = Transaction::find($id);
        if(Auth::check()){
            if(empty($tran))
                return redirect()->route('getorderinfo', ['order_email' => Auth::user()->email, 'order_phone' => Auth::user()->phone])->with(['flag' => 'danger', 'message' => 'Đơn hàng này không tồn tại.']);
            if($tran->customer_id != Auth::user()->id)
                 return redirect()->route('getorderinfo', ['order_email' => Auth::user()->email, 'order_phone' => Auth::user()->phone])->with(['flag' => 'danger', 'message' => 'Bạn không có quyền hủy đơn hàng này.']);

            $effected_row = Transaction::where('id', $tran->id)->update(['status_id' => $this->user_cancel_status]);
            $orders = Orders::where('transaction_id', $tran->id)->get();
            foreach ($orders as $odr) {
                Orders::where('id', $odr->id)->update(['status_id' => $this->user_cancel_status]);    
            }

            if($effected_row == 0)
                 return redirect()->route('getorderinfo', ['order_email' => Auth::user()->email, 'order_phone' => Auth::user()->phone])->with(['flag' => 'danger', 'message' => 'Hủy đơn hàng thất bại, vui lòng thử lại.']);

            return redirect()->route('getorderinfo', ['order_email' => Auth::user()->email, 'order_phone' => Auth::user()->phone])->with(['flag' => 'success', 'message' => 'Hủy đơn hàng thành công.']);                           
        }
        return redirect()->route('loginpage')->with(['flag' => 'danger', 'message' => 'Bạn phải đăng nhập trước khi sử dụng chức năng này.']);
    }

    //Admin cập nhật trạng thái đơn hàng
    public function updateTransactionInfo(Request $req){
        if($req->isMethod('post')){

            //lấy thông tin cập nhật
            $tran_id = $req->tran_id;
            $stt_selected = $req->get('update_stt_option');
            $note = $req->orders_note;
            $orders_selected = $req->get('select_product');

            //lấy thông tin transaction và trạng thái
            $tran_data = Transaction::find($tran_id);
            $stt_data = Status::find($stt_selected);
            if(empty($tran_data)||empty($stt_data))
                return redirect()->route('listtransactions')->with(['flag' => 'danger', 'message' => 'Không tìm thấy đơn hàng hoặc trạng thái.']);

            //Lấy danh sách các chi tiết đơn hàng
            $list_orders = Orders::where('transaction_id', $tran_data->id)->get();
            if(empty($list_orders))
                    return redirect()->route('listtransactions')->with(['flag' => 'danger', 'message' => 'Không tìm thấy sản phẩm nào trong đơn hàng.']);

            //lấy thông tin người dùng    
            $customer_id  = $tran_data->customer_id;
            $customer = User::find($customer_id);    

            if($orders_selected==0){

                //lấy điểm của các đơn hàng đc cập nhật là thành công
                $success_point = 0;

                //cập nhật trạng thái tất cả ctdh
                foreach ($list_orders as $odr) {
                    if(!in_array($odr->status_id, $this->finish_stt_arr)){
                        if($stt_selected == $this->success_stt){
                            $success_point += $odr->amount;

                            //cập nhật lại số lượng sản phẩm
                            $product = Product::find($odr->product_id);
                            $buy = $product->buy_count;
                            $quantity = $product->quantity;
                            Product::where('id',$odr->product_id)->update(['buy_count' => $buy+1, 'quantity' => $quantity - $odr->quantity]);
                        }
                        Orders::where('id', $odr->id)->update(['status_id' => $stt_selected]);
                    }       
                }

                //cập nhật trạng thái đơn hàng
                $tran_data->status_id = $stt_selected;
                if(!empty($note))
                    $tran_data->note = $note;
                $tran_data->save();

                //Nếu đơn hàng thành công thì:
                //cập nhật lại điểm của khách hàng
                if(!empty($customer)){
                    $point = $customer->point;
                    $point = $point + $success_point;
                    $user_type = UserType::all();
                    //cập nhật loại khách hàng
                    foreach ($user_type as $type) {
                        if($point >= $type->minpoint && $point <= $type->maxpoint){
                            User::where('id', $customer_id)->update(['type' => $type->id]);
                        }
                    }
                    User::where('id', $customer_id)->update(['point' => $point]);
                }
                return redirect()->route('viewtraninfo', ['id' => $tran_id])->with(['flag' => 'success', 'message' => 'Cập nhật trạng thái đơn hàng thành công.']);
            }

            //kiểm tra điều kiện nhập vào của orders selected
            $orders_info = Orders::find($orders_selected);
            
            if(empty($orders_info) || $orders_info->transaction_id != $tran_id)
                return redirect()->back()->with(['flag' => 'danger', 'message' => 'Sản phẩm này không tồn tại trong đơn hàng.']);

            //kiểm tra nếu đơn hàng thuộc các trạng thái hoàn tất
            if(in_array($orders_info->status_id, $this->finish_stt_arr))
                return redirect()->back()->with(['flag' => 'danger', 'message' => 'Không thể cập nhật trạng thái cho sản phẩm này.']);

            //cập nhật từng chi tiết đơn hàng
            $orders_info->status_id = $stt_selected;

            //nếu trạng thái là thành công thì cập nhật lại điểm KH và số lượng sản phẩm
            if($stt_selected == $this->success_stt){
                if(!empty($customer)){
                    $point = $customer->point;
                    $point = $point + $orders_info->amount;
                    $user_type = UserType::all();
                    //cập nhật loại khách hàng
                    foreach ($user_type as $type) {
                        if($point >= $type->minpoint && $point <= $type->maxpoint){
                            User::where('id', $customer_id)->update(['type' => $type->id]);
                        }
                    }
                    User::where('id', $customer_id)->update(['point' => $point]);
                }
                //cập nhật lại số lượng sản phẩm
                $product = Product::find($orders_info->product_id);
                $buy = $product->buy_count;
                $quantity = $product->quantity;
                Product::where('id',$orders_info->product_id)->update(['buy_count' => $buy+1, 'quantity' => $quantity - $orders_info->quantity]);
            }

            //Nếu hủy một trong những sản phẩm của đơn hàng thì cập nhật lại giá trị đơn hàng
            if(in_array($stt_selected, $this->return_transfer)){
                $tran_data->total_amount = $tran_data->total_amount - $orders_info->amount;
            }

            if($orders_info->save()){
                //kiểm tra trạng thái của các chi tiết đơn hàng, nếu tất cả chi tiết đơn hàng có trạng thái giống nhau thì cập nhật trạng thái của đơn hàng
                $check_status = true;
                $saved_list_orders = Orders::where('transaction_id', $tran_data->id)->get();
                $default_stt = $saved_list_orders[0]->status_id;
                foreach ($saved_list_orders as $item) {
                    if($item->status_id != $default_stt)
                        $check_status = false;
                }

                if($check_status){
                    $tran_data->status_id = $default_stt;
                }
                else{
                    $check_finish = true;
                    foreach ($saved_list_orders as $item) {
                        if(!in_array($item->status_id, $this->finish_stt_arr))
                            $check_finish = false;
                    }
                    if($check_finish)
                        $tran_data->status_id = $this->success_stt;
                    else
                        $tran_data->status_id = $this->transfer_stt;
                }
            }
            if(empty($note))
                $note = '';
            $tran_data->note = $note;
            $tran_data->save();
            return redirect()->route('viewtraninfo', ['id' => $tran_id])->with(['flag' => 'success', 'message' => 'Cập nhật trạng thái đơn hàng thành công.']);
        }
        return redirect()->route('listtransactions')->with(['flag' => 'danger', 'message' => 'Không tìm thấy phương thức post.']);
    }

    //xuất hóa đơn
    public function exportInvoice($id){
        $data = Transaction::find($id);
        if(empty($data))
            return redirect()->route('listtransactions')->with(['flag' => 'danger', 'message' => 'Không tìm thấy đơn hàng nào.']);
        $i = 0;
        $orders = Orders::where('transaction_id', $id)->get();
        foreach ($orders as $od) {
            if(in_array($od->status_id, $this->fail_arr)){
                unset($orders[$i]);
                $i++;
            }
            $product = Product::where('id',$od->product_id)->first();
            $od->product_name = $product->name;
            $od->product_price = $product->original_price; 
        }
        $pdf = PDF::loadView('admin.layout.orders.invoice', compact('data', 'orders'));
        PDF::setOptions(['DOMPDF_ENABLE_CSS_FLOAT' => true]);
        return $pdf->download('invoice_'.$id.'_'.time().'.pdf');
        //return view('admin.layout.orders.invoice', compact('data', 'orders'));
    }
}
