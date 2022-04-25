<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Resource;
use App\Models\color;
use App\Models\coupon;
use App\Models\deliveryInformation;
use App\Models\memory;
use App\Models\order;
use App\Models\product;
use App\Models\tag;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class orderController extends Controller
{
    public $order;
    public $product;
    public $coupon;
    public $deliveryInformation;
    public $color;
    public $memory;
    public $tag;
    public $user;

    public function __construct(order $order,product $product,coupon $coupon,deliveryInformation $deliveryInformation,color $color,memory $memory,tag $tag,User $user){
        $this->order = $order;
        $this->product = $product;
        $this->coupon = $coupon;
        $this->deliveryInformation = $deliveryInformation;
        $this->color = $color;
        $this->memory = $memory;
        $this->tag = $tag;
        $this->user = $user;
    }
    public function store(Request $request){
        $request->validate([
            'product_id' => 'required',
            'quantity' => 'required|min:1|max:10'
        ]);

        $arr = array(
            'quantity' => $request->quantity,
            'method_payment' => $request->method_payment,
            'date' => Carbon::now()->toDateTimeString(),
            'status' => 0
        );
        if($request->user_id){
            $user = $this->user->find($request->user_id);
            if($user){
                $arr['user_id'] = $request->user_id;
            }else{
                return response()->json([
                    'code' => 403,
                    'message' => 'invalid user information !'
                ],403);
            }
        }else{
            $arr['user_id'] = null;
        }
        if($request->deliveryInformation_id){
            $deliveryInformation = $this->deliveryInformation->find($request->deliveryInformation_id);
            if($deliveryInformation){
                $arr['deliveryInformation_id'] = $request->deliveryInformation_id;
            }else{
                return response()->json([
                    'code' => 403,
                    'message' => 'invalid delivery information !'
                ],403);
            }
        }else if($request->name && $request->address && $request->phone){
            $newDeliveryInformation = $this->deliveryInformation->create([
                'name' => $request->name,
                'address' => $request->address,
                'phone' => $request->phone,
                'user_id' => 0
            ]);

            $arr['deliveryInformation_id'] = $newDeliveryInformation->id;
        }else{
            return response()->json([
                'code' => 403,
                'message' => 'invalid information !'
            ],403);
        }

        if($request->coupon_id){
            $coupon = $this->coupon->find($request->coupon_id);
            if($coupon){
                $arr['coupon_id'] = $request->coupon_id;
            }else{
                return response()->json([
                    'code' => 403,
                    'message' => 'invalid coupon information !'
                ],403);
            }
        }
        if($request->product_id){
            $product = $this->product->find($request->product_id);
            if($product){
                $arr['product_id'] = $request->product_id;
                $price_total = $product->current_price * $request->quantity;
                $profit = $product->origin_price * $request->quantity;
                if($request->color_id){
                    $color = $this->color->where('id',$request->color_id)->where('product_id',$request->product_id)->first();
                    if($color){
                        $arr['color_id'] = $request->color_id;
                        $price_total += $color->price;
                    }
                }

                if($request->memory_id){
                    $memory = DB::table('tbl_product_memory')->where('memory_id',$request->memory_id)->where('product_id',$request->product_id)->first();
                    if($memory){
                        $arr['memory_id'] = $request->memory_id;
                        $price_total += $memory->price;
                    }
                }
                if($request->tag_id){
                    $tag = DB::table('tbl_product_tag')->where('tag_id',$request->tag_id)->where('product_id',$request->product_id)->first();
                    if($tag){
                        $arr['tags_id'] = $request->tag_id;
                        $price_total += $tag->price;
                    }
                }
                if($coupon){
                    $usedUser = explode(",", $coupon->usedUser);
                    foreach ($usedUser as $key => $userItem) {
                        if($userItem == $request->user_id){
                                return response()->json([
                                    'code' => 403,
                                    'message' => 'user used this code !'
                                ],403);
                            }
                        }
                    
                    if($coupon->type == 'percent'){
                        $price_total = $price_total - ($price_total * ($coupon->value/100));
                        $usedUser = $coupon->usedUser . $request->user_id;
                        $coupon->update(['quantity' => $coupon->quantity - 1]);
                    }else{
                        if($price_total < $coupon->value){
                            $price_total = 0 ;
                        }else{
                            $price_total = $price_total - $coupon->value;

                        }
                    }
                }
                $arr['price_total'] = $price_total;
                $newOrder = $this->order->create($arr);
                return response()->json([
                    'code' => 200,
                    'data' => new Resource($newOrder)
                ],200);
            }else{
                return response()->json([
                    'code' => 403,
                    'message' => 'invalid product information !'
                ],403);
            }
        }else{
            return response()->json([
                'code' => 403,
                'message' => 'invalid product information !'
            ],403);
        }


    }
}
