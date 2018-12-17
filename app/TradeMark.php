<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TradeMark extends Model
{
	public $timestamps = false; //off if don't have column create_at and update_at in table
    //
    protected $table = "trademark";

	//quan hệ thương hiệu<->sp là 1-n: 1 thương hiệu bao gồm nhiều sp
    public function product(){
    	return $this->hasMany('App\Product', 'trademark_id', 'id');
    }
}
