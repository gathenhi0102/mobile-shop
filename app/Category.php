<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
    protected $table = "category";

    public $timestamps = false; //off if don't have column create_at and update_at in table
    //quan hệ loại sp<->sp là 1-n: 1 loại sp bao gồm nhiều sp
    public function product(){
    	return $this->hasMany('App\Product', 'category_id', 'id');
    }

}
