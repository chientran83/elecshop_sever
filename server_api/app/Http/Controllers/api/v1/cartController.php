<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\cartResource;
use App\Models\cart;
use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class cartController extends Controller
{
    public $cart;
    public $product;
    public function __construct(cart $cart,product $product){
        $this->cart = $cart;
        $this->product = $product;
    }
    public function show(Request $request){
        $user_login = auth()->user();
        $cart =  $user_login->cart;
        return new cartResource($cart);
    }
    public function add_product(Request $request){
        $user_login = auth()->user();
        $cart =  $user_login->cart;
        if($cart->product->contains('id',$request->product_id)){
            $table_cart_product = DB::table('tbl_cart_product')->where('cart_id',$cart->id)->where('product_id',$request->product_id)->first();
            DB::table('tbl_cart_product')->where('cart_id',$cart->id)->where('product_id',$request->product_id)->update(['quantity' => $table_cart_product->quantity + $request->quantity]);
        }else{
            $cart->product()->attach($request->product_id,['quantity' => $request->quantity]);
            $cart->update(['quantity'=>$cart->quantity+1]);
        }

        $user_login = auth()->user();
        $cart =  $user_login->cart;
        return new cartResource($cart);
    }
    public function update_product(Request $request){
        $user_login = auth()->user();
        $cart =  $user_login->cart;
        $product = $this->product->find($request->product_id);
        DB::table('tbl_cart_product')->where('cart_id',$cart->id)->where('product_id',$product->id)->update(['quantity' => $request->quantity]);
        $user_login = auth()->user();
        $cart =  $user_login->cart;
        return new cartResource($cart);
    }
    public function delete_product(Request $request){
        $user_login = auth()->user();
        $cart =  $user_login->cart;
        $cart->update(['quantity' => $cart->quantity-1]);
        DB::table('tbl_cart_product')->where('cart_id',$cart->id)->where('product_id',$request->product_id)->delete();
        $user_login = auth()->user();
        $cart =  $user_login->cart;
        return new cartResource($cart);
    }
}
