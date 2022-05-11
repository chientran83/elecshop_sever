<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\orderCollection;
use App\Http\Resources\v1\orderResource;
use App\Http\Resources\v1\Resource;
use App\Models\color;
use App\Models\coupon;
use App\Models\deliveryInformation;
use App\Models\memory;
use App\Models\order;
use App\Models\product;
use App\Models\statistic;
use App\Models\tag;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

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
    public $statistic;

    public function __construct(order $order,product $product,coupon $coupon,deliveryInformation $deliveryInformation,color $color,memory $memory,tag $tag,User $user,statistic $statistic){
        $this->order = $order;
        $this->product = $product;
        $this->coupon = $coupon;
        $this->deliveryInformation = $deliveryInformation;
        $this->color = $color;
        $this->memory = $memory;
        $this->tag = $tag;
        $this->user = $user;
        $this->statistic = $statistic;
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
        if($request->product_id){
            $product = $this->product->find($request->product_id);
            if($product){
                $arr['product_id'] = $request->product_id;
                $price_total = $product->current_price * $request->quantity;
               

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

                if($request->tags_id){
                    $tag = DB::table('tbl_product_tag')->where('tag_id',$request->tags_id)->where('product_id',$request->product_id)->first();
                    
                    if($tag){
                        $arr['tags_id'] = $request->tags_id;
                        $price_total += $tag->price;
                    }
                }
                if($request->user_id){
                    $user = $this->user->find($request->user_id);
                    if($user){
                        $arr['user_id'] = $request->user_id;
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
                    }else{
                        return response()->json([
                            'code' => 403,
                            'message' => 'invalid user information !'
                        ],403);
                    }
                }else{
                    $arr['user_id'] = 0;
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
                $arr['price_total'] = $price_total;
                //check payment

                if($request->method_payment == 'paypal'){
                    $provider = new PayPalClient;
                    $provider->setApiCredentials(config('paypal'));
                    $paypalToken = $provider->getAccessToken();

                    $response = $provider->createOrder([
                        "intent" => "CAPTURE",
                        "application_context" => [
                            "return_url" => route('successTransaction',['orderData' => $arr]),
                            "cancel_url" => route('cancelTransaction'),
                        ],
                        "purchase_units" => [
                            0 => [
                                "amount" => [
                                    "currency_code" => "USD",
                                    "value" => "10"
                                ]
                            ]
                        ]
                    ]);

                    if (isset($response['id']) && $response['id'] != null) {
                        // redirect to approve href
                        foreach ($response['links'] as $links) {
                            
                            if ($links['rel'] == 'approve') {

                                //link payment
                                return response()->json([
                                    'code' => 200,
                                    'data' => $links['href']
                                ],200);
                                // return redirect()->away($links['href']);
                            }
                        }


                        return response()->json([
                            'code' => 500,
                            'data' => 'Something went wrong.'
                        ],500);
                    } else {
                        return response()->json([
                            'code' => 500,
                            'data' => $response['message'] ?? 'Something went wrong.'
                        ],500);
                    }   
                }else{
                    $arr['method_payment'] = 'postpaid';
                }

                $newOrder = $this->order->create($arr);

                return response()->json([
                    'code' => 200,
                    'data' => new orderResource($newOrder)
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

    public function successTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            
            $newOrder = $this->order->create($request->orderData);
 
            /* return response()->json([
                'code' => 200,
                'message' => 'Transaction complete.',
                'data' => new orderResource($newOrder)
            ],200); */


        } else {
            return response()->json([
                'code' => 500,
                'message' => $response['message'] ?? 'Something went wrong.'
            ],500);
        }
    }

    public function cancelTransaction(Request $request)
    {
        return response()->json([
            'code' => 500,
            'message' => 'You have canceled the transaction.'
        ],500);
    }

    public function index($recordNumber){
        $userLogin = auth()->user();
        if($recordNumber == 0){
            return new orderCollection($userLogin->order);
        }else{
            return new orderCollection($this->order->where('user_id',$userLogin->id)->paginate($recordNumber));
        }
    }
    public function indexForAdmin($recordNumber){
        if($recordNumber == 0){
            return new orderCollection($this->order->all());
        }else{
            return new orderCollection($this->order->paginate($recordNumber));
        }
    }
    public function show(Request $request){
        return new orderResource($this->order->where('id',$request->id)->first());
    }

    public function changeStatusOrder(Request $request){
        $orderItem = $this->order->where('id',$request->id)->first();
        if($orderItem){
            if($orderItem->status < 3){
                $this->order->where('id',$request->id)->update(['status' => $orderItem->status + 1]);
            }
            return new orderResource($this->order->where('id',$request->id)->first());
        }else{
            return response()->json([
                'code' => 404,
                'message' => 'order undefined !'
            ],404);
        }
    }

    // admin delete order
    public function rejectOrder(Request $request){
        $orderItem = $this->order->where('id',$request->id)->first();
        if($orderItem){
            $this->order->where('id',$request->id)->delete();
            return 1;
        }else{
            return response()->json([
                'code' => 404,
                'message' => 'order undefined !'
            ],404);
        }
        
    }

    // user cancel order
    public function cancelOrder(Request $request){
        $orderItem = $this->order->where('id',$request->id)->first();
        if($orderItem){
            if($orderItem->status == 0){
                $this->order->where('id',$request->id)->update(['status' => 4]);
                return new orderResource($this->order->where('id',$request->id)->first());
            }else{
                return response()->json([
                    'code' => 400,
                    'message' => 'order confirmed , not reject !'
                ],400);
            }
        }else{
            return response()->json([
                'code' => 404,
                'message' => 'order undefined !'
            ],404);
        }
    }

    public function acceptOrder(Request $request){
        $orderItem = $this->order->where('id',$request->id)->first();
        if($orderItem){
            if($orderItem->status == 0){
                $this->order->where('id',$request->id)->update(['status' => 1]);
                return new orderResource($this->order->where('id',$request->id)->first());
            }else{
                return response()->json([
                    'code' => 400,
                    'message' => 'order confirmed , not reject !'
                ],400);
            }
        }else{
            return response()->json([
                'code' => 404,
                'message' => 'order undefined !'
            ],404);
        }
    }
}
