<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TradeMark;

class TrademarkController extends Controller
{
    //system default value
    protected $prevent_min_id = 1;
    protected $prevent_max_id = 9;

    //lấy danh sách thương hiệu
    public function getListTrademark(){
    	$trademark = TradeMark::all();
    	return view('admin.layout.trademark.listview', compact('trademark'));
    }

    public function getInsertTrademark(){

    	return view('admin.layout.trademark.insert');
    }

    public function postTrademarkInfo(Request $req){
    	if($req->isMethod('post')){
    		$this->validate($req,
                [
                    'trademark_name' => 'required|min:1|max:190|unique:trademark,name'
                ],

                [
                	'trademark_name.required' =>'Vui lòng nhập tên thương hiệu',
                    'trademark_name.min' =>'Tên thương hiệu phải có tối thiểu 1 ký tự',
                    'trademark_name.max' =>'Tên thương hiệu có tối đa 190 ký tự',
                    'trademark_name.unique' =>'Tên thương hiệu này đã tồn tại'
                ]
            );

            if(empty($req->trademark_id)){
            	$trademark = new TradeMark;
            	$trademark->name = $req->trademark_name;
            	$trademark->description = $req->trademark_description;
            	if($trademark->save())
            		return redirect()->route('listtrademark')->with(['flag' => 'success', 'message' => 'THÊM THƯƠNG HIỆU MỚI THÀNH CÔNG.']);
            	return redirect()->back()->with(['flag' => 'danger', 'message' => 'CÓ LỖI XẢY RA, VUI LÒNG THỬ LẠI']);
            }

            $trademark = TradeMark::find($req->trademark_id);
            if(empty($trademark))
            	redirect()->back()->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY THÔNG TIN CỦA THƯƠNG HIỆU NÀY']);
            $trademark->name = $req->trademark_name;
            $trademark->description = $req->trademark_description;
            if($trademark->save())
            		return redirect()->back()->with(['flag' => 'success', 'message' => 'CHỈNH SỬA THƯƠNG HIỆU THÀNH CÔNG.']);
            	return redirect()->back()->with(['flag' => 'danger', 'message' => 'CÓ LỖI XẢY RA, VUI LÒNG THỬ LẠI']);
    	}
    	return redirect()->back()->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY PHƯƠNG THỨC POST.']);
    }

    public function getEditTrademarkInfo($id){
    	$trademark_info = TradeMark::find($id);
    	if(empty($trademark_info))
    		return redirect()->route('listtrademark')->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY THÔNG TIN.']);
    	return view('admin.layout.trademark.edit', compact('trademark_info'));
    }

    //xóa thương hiệu
    public function getDeleteTrademark($id){
        $trademark_info = TradeMark::find($id);
        if(empty($trademark_info))
            return redirect()->route('listtrademark')->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY THÔNG TIN CẦN XÓA.']);
        //tránh phá hoại hệ thống
        if($trademark_info->id >= $this->prevent_min_id && $trademark_info->id <= $this->prevent_max_id)
            return redirect()->route('listtrademark')->with(['flag' => 'danger', 'message' => 'BẠN KHÔNG THỂ XÓA THÔNG TIN NÀY.']);
        $trademark_info->delete();
        return redirect()->route('listtrademark')->with(['flag' => 'success', 'message' => 'XÓA THÔNG TIN THÀNH CÔNG.']);
    }

}
