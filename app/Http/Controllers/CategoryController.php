<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class CategoryController extends Controller
{
    //system default value
    protected $prevent_min_id = 1;
    protected $prevent_max_id = 3;

    //lấy danh sách thể loại
    public function getListCategory(){
    	$category = Category::all();
    	return view('admin.layout.category.listview', compact('category'));
    }

    public function getInsertCategory(){
    	return view('admin.layout.category.insert');
    }

    public function postCategoryInfo(Request $req){
    	if($req->isMethod('post')){
    		$this->validate($req,
                [
                    'category_name' => 'required|min:4|max:190|unique:category,name'
                ],

                [
                	'category_name.required' =>'Vui lòng nhập tên thể loại',
                    'category_name.min' =>'Tên thể loại phải có tối thiểu 4 ký tự',
                    'category_name.max' =>'Tên thể loại có tối đa 190 ký tự',
                    'category_name.unique' =>'Tên thể loại này đã tồn tại'
                ]
            );

            if(empty($req->category_id)){
            	$category = new Category;
            	$category->name = $req->category_name;
            	$category->description = $req->category_description;
            	if($category->save())
            		return redirect()->route('listcategory')->with(['flag' => 'success', 'message' => 'THÊM THỂ LOẠI MỚI THÀNH CÔNG.']);
            	return redirect()->back()->with(['flag' => 'danger', 'message' => 'CÓ LỖI XẢY RA, VUI LÒNG THỬ LẠI']);
            }

            $category = Category::find($req->category_id);
            if(empty($category))
            	redirect()->back()->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY THÔNG TIN CỦA THỂ LOẠI NÀY']);
            $category->name = $req->category_name;
            $category->description = $req->category_description;
            if($category->save())
            		return redirect()->back()->with(['flag' => 'success', 'message' => 'CHỈNH SỬA THỂ LOẠI THÀNH CÔNG.']);
            	return redirect()->back()->with(['flag' => 'danger', 'message' => 'CÓ LỖI XẢY RA, VUI LÒNG THỬ LẠI']);
    	}
    	return redirect()->back()->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY PHƯƠNG THỨC POST.']);
    }

    public function getEditCategoryInfo($id){
    	$category_info = Category::find($id);
    	if(empty($category_info))
    		return redirect()->route('listcategory')->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY THÔNG TIN.']);
    	return view('admin.layout.category.edit', compact('category_info'));
    }

    public function getDeleteCategory($id){
    	$category_info = Category::find($id);
        if(empty($category_info))
            return redirect()->route('listcategory')->with(['flag' => 'danger', 'message' => 'KHÔNG TÌM THẤY THÔNG TIN CẦN XÓA.']);
        if($category_info->id >= $this->prevent_min_id && $category_info->id <= $this->prevent_max_id)
            return redirect()->route('listcategory')->with(['flag' => 'danger', 'message' => 'BẠN KHÔNG THỂ XÓA THÔNG TIN NÀY.']);
        $category_info->delete();
        return redirect()->route('listcategory')->with(['flag' => 'success', 'message' => 'XÓA THÔNG TIN THÀNH CÔNG.']);
    }
}
