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
        $table_cart_product = DB::table('tbl_cart_product')->where('cart_id',$cart->id)->where('product_id',$request->product_id)->get();
        $orderId = 0;
        foreach ($table_cart_product as $key => $value) {
            if($value->memory_id == $request->memory_id && $value->color_id == $request->color_id && $value->tag_id == $request->tag_id){
                $orderId = $value->id;
            }
        }
        if($table_cart_product && $orderId != 0){
            $productUpdateId  = DB::table('tbl_cart_product')->where('id',$orderId)->first();
            DB::table('tbl_cart_product')->where('id',$productUpdateId->id)->update(['quantity' => $productUpdateId->quantity + $request->quantity]);
        }else{
            $cart->product()->attach($request->product_id,[
                'quantity' => $request->quantity,
                'color_id' => $request->color_id,
                'memory_id' => $request->memory_id,
                'tag_id' => $request->tag_id
            ]);
            $cart->update(['quantity'=>$cart->quantity+1]);

        }
        $user_login = auth()->user();
        $cart =  $user_login->cart;
        return new cartResource($cart);
    }


    public function update_product(Request $request){
        $userLogin = auth()->user();
        $cart =  $userLogin->cart;
        $orderProduct = DB::table('tbl_cart_product')->where('cart_id',$cart->id)->where('id',$request->orderProductId)->first();
        if($orderProduct){
           DB::table('tbl_cart_product')->where('cart_id',$cart->id)->where('id',$request->orderProductId)->update(['quantity' => $request->quantity]);
           $cart =  $userLogin->cart;
           return new cartResource($cart);
        }else{
            return response()->json([
                'code' => 403,
                'message' => "product undefined !",
            ],403);
        }
    }

    public function delete_product(Request $request){
        $userLogin = auth()->user();
        $cart =  $userLogin->cart;
        $orderProduct = DB::table('tbl_cart_product')->where('cart_id',$cart->id)->where('id',$request->orderProductId)->first();
        if($orderProduct){
           DB::table('tbl_cart_product')->where('cart_id',$cart->id)->where('id',$request->orderProductId)->delete();
           $cart =  $userLogin->cart;
           return new cartResource($cart);
        }else{
            return response()->json([
                'code' => 403,
                'message' => "product undefined !",
            ],403);
        }
    }
}
