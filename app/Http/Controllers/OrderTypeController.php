<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;

class OrderTypeController extends Controller
{
    //system default value
    protected $prevent_min_id = 1;
    protected $prevent_max_id = 16;
    
    //lấy danh sách trạng thái đơn hàng
    public function getListOrderStatus(){
    	$stt_list = Status::all();
    	return view('admin.layout.orderstatus.listview', compact('stt_list'));
    }

    //hiển thị form nhập thông tin
    public function getInsertStatus(){
    	return view('admin.layout.orderstatus.insert');
    }

    //gửi dữ liệu lên server
    public function postOrderStatusInfo(Request $req){
    	if($req->isMethod('post')){
    		$this->validate($req,
                [
                    'orderstatus_name' => 'required|min:1|max:190|unique:status,name'
                ],

                [
                	'orderstatus_name.required' =>'Vui lòng nhập tên trạng thái',
                    'orderstatus_name.min' =>'Tên trạng thái phải có tối thiểu 1 ký tự',
                    'orderstatus_name.max' =>'Tên trạng thái có tối đa 190 ký tự',
                    'orderstatus_name.unique' =>'Tên trạng thái này đã tồn tại'
                ]
            );

    		//insert
            if(empty($req->orderstatus_id)){
            	$status = new Status;
            	$status->name = $req->orderstatus_name;
            	$status->description = $req->orderstatus_description;
            	if($status->save())
            		return redirect()->back()->with(['flag' => 'success', 'message' => 'THÊM TRẠNG THÁI MỚI THÀNH CÔNG.']);
            	return redirect()->back()->with(['flag' => 'danger', 'message' => 'CÓ LỖI XẢY RA, VUI LÒNG THỬ LẠI']);
            }
            //update

            $status = Status::find($req->orderstatus_id);
            if(empty($status))
            	redirect()->back()->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY THÔNG TIN CỦA TRẠNG THÁI NÀY']);
            $status->name = $req->orderstatus_name;
            $status->description = $req->orderstatus_description;
            if($status->save())
            		return redirect()->back()->with(['flag' => 'success', 'message' => 'CHỈNH SỬA TRẠNG THÁI THÀNH CÔNG.']);
            	return redirect()->back()->with(['flag' => 'danger', 'message' => 'CÓ LỖI XẢY RA, VUI LÒNG THỬ LẠI']);

    	}
    	return redirect()->back()->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY PHƯƠNG THỨC POST.']);
    }

    //xóa trạng thái
    public function getDeleteOrderStatus($id){
        $status_info = Status::find($id);
        if(empty($status_info))
            return redirect()->route('getlistorderstatus')->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY THÔNG TIN CẦN XÓA.']);
        if($status_info->id >= $this->prevent_min_id && $status_info->id <= $this->prevent_max_id)
            return redirect()->route('getlistorderstatus')->with(['flag' => 'danger', 'message' => 'BẠN KHÔNG THỂ XÓA THÔNG TIN NÀY.']);
        $status_info->delete();
        return redirect()->route('getlistorderstatus')->with(['flag' => 'success', 'message' => 'XÓA THÔNG TIN THÀNH CÔNG.']);
    }

    //sửa trạng thái
    public function getEditStatusInfo($id){
    	$status_info = Status::find($id);
    	if(empty($status_info))
    		return redirect()->route('getlistorderstatus')->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY THÔNG TIN.']);
    	return view('admin.layout.orderstatus.edit', compact('status_info'));
    }
}
