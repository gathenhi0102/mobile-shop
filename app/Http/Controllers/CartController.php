<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use Cart;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CartController extends Controller
{
    //giỏ hàng
    public function addToCart(Request $req){
    	if($req->isMethod('post')){
    		$product_id = $req->get('product_id');
    		$product_quantity = $req->get('quantity_input');
    		$product = Product::where('id', $product_id)->first();
    		$cart_info = [
    			'id' => $product_id,
    			'name' => $product->name,
    			'price' => $product->original_price,
    			'qty' => $product_quantity,
    			'options' =>['image' => $product->main_image]
    		];
    		Cart::add($cart_info);
    	}
    	return redirect()->route('cartinfo');
    }

    public function getCart(){
    	$cart = Cart::content();
    	$total = Cart::subtotal(0,',','.');
    	return view('page.cart', compact('cart', 'total'));
    }

    public function delCart($id){
    	Cart::remove($id);
    	return redirect()->route('cartinfo');
    }

    // public function test($id){
    //     try {
    //         $data = Product::findOrFail($id);
    //         return $data;
    //     } catch (ModelNotFoundException $ex) {
    //         return "not found";
    //     }
    // }
   
}
