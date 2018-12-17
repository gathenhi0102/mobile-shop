<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    //
    public function postComment(Request $req){
    	if($req->isMethod('post')){
    		$comment = new Comment();
    		$comment->user_id = $req->user_id;
    		$comment->user_name = $req->user_name;
    		$comment->product_id = $req->product_id;
    		$comment->content = $req->feedback_content;
    		if($comment->save())
    			return redirect("product/$req->product_id");
    	}
    }
}
