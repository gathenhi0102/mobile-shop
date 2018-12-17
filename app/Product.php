<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
    protected $table = "product";


    //quan hệ sp<->loại sp là 1-1: 1 sp thuộc về 1 loại sp nào đó
    public function category(){
    	return $this->belongsTo('App\Category', 'category_id', 'id'); 
    }

    //quan hệ sp<->thương hiệu là 1-1: 1 sp thuộc về 1 thương hiệu nào đó
    public function trademark(){
    	return $this->belongsTo('App\TradeMark', 'trademark_id', 'id'); 
    }

    //quan hệ sp - cthd là 1-n, id product có nhiều cthd( 1sp đc lặp lại nhiều lần trong bảng cthd)
    public function orders(){
    	return $this->hasMany('App\Orders', 'product_id', 'id'); 
    }
}
