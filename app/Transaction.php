<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $table = "transaction";

    // 1 hđ có nhiều cthd(1-n)
    public function orders(){
    	return $this->hasMany('App\Orders', 'transaction_id', 'id'); 
    }

    //1 hđ thuộc về 1 kh
    public function user(){
    	return $this->belongsTo('App\User', 'customer_id', 'id'); 
    }
}
