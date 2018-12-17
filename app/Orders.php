<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    //
    protected $table = "orders";

    // mỗi cthd chỉ đc chứa 1 sp (1-1)
    public function product(){
    	return $this->belongsTo('App\Product', 'product_id', 'id'); 
    }

    //cthd thuộc về 1 hđ nào đó
    public function transaction(){
    	return $this->belongsTo('App\Transaction', 'transaction_id', 'id'); 
    }
}
