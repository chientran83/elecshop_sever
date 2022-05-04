<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Collection;
use App\Http\Resources\v1\Resource;
use App\Http\Resources\v1\userCollection;
use App\Http\Resources\v1\userResource;
use App\Models\cart;
use App\Models\deliveryInformation;
use App\Models\statistic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class userController extends Controller
{
    public $users;
    public $cart;    
    public $statistic;    

    public function __construct(User $users,cart $cart,statistic $statistic) {
        $this->users = $users;
        $this->cart = $cart;
        $this->statistic = $statistic;
    }
 
    public function index($record_number)
    {
        if($record_number == 0){
            return new userCollection(User::all());
            
        }else{
            return new userCollection(User::paginate($record_number));

        }
    }

   
    public function create(Request $request)
    {
    }

 
    public function store(Request $request)
    {
        if($request->password == $request->passwordAgain){
            $image_path = "";
            if($request->hasFile('image')){
                $file = $request->file('image');
                $image_hash_name = Str::random(20).'.'.$file->extension();
                $store = $file->storeAs('public/user/1',$image_hash_name);    
                $image_path = Storage::url($store);
            }
            $new_user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make( $request->password),
                'image_path' => $image_path,
                'phoneNumber' => $request->phoneNumber,
                'location' => $request->location]);
                
            $list_role = json_decode($request->roles);
            $this->cart->create(['user_id'=>$new_user->id,'quantity'=>0]);
            if(!empty($list_role)){
               foreach($list_role as $item_role){
                $new_user->role()->attach($item_role->id);
               }
            }
            return response()->json([
                'code' => 201,
                'data' => new userResource($new_user)
            ],201);
        }else{
            return response()->json([
                'code' => 422,
                'message' => "Invalid password !"
            ],422);
        }
    }
    
    public function login(Request $request)
    {
        if(! $token = auth()->attempt(['email' => $request->email,'password' => $request->password])){
            return response()->json([
                'code' => 500,
                'message' => 'email or password incorrect!'
            ]);
        }else{
            return $this->createNewToken($token);
        }
    }

    protected function createNewToken($token){
        $minute = 180;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            /* getTTL() == 60 , 60 * 60 = 3600 = 1h */
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ])->withCookie(cookie('elecshop_login', $token , $minute));
    }

    public function logout()
    {
        auth()->logout();
        return response()->json([
            'code' => 201,
            'message' => 'logout success!'
        ],201);
    }
    public function refresh_token(Request $request)
    {
        return $this->createNewToken(auth()->refresh());
    }

    

    public function show($id)
    {
        $user_item = User::find($id);
        if($user_item){
            return response()->json([
                'code' => 201,
                'data' => new userResource($user_item)
            ],201)/* ->withCookie(cookie('name', 'value', 1)) */;
        }else{
            return response()->json([
                'code' => 404,
                'message' => 'user not found!'
            ],201);
        }
    }

    
    public function updateCustomer(Request $request)
    {
        $item_user = $this->users->find(auth()->user()->id);
        $image_path = $item_user->image_path;
        if($request->hasFile('image')){
            $file = $request->file('image');
            $image_hash_name = Str::random(20).'.'.$file->extension();
            $store = $file->storeAs('public/user/1',$image_hash_name);
            $image_path = Storage::url($store);
        }
        $item_user->update([
            'name' => $request->name,
            'email' => $request->email,
            'image_path' => $image_path,
            'phoneNumber' => $request->phoneNumber,
            'location' => $request->location]);
 
        return response()->json([
            'code' => 201,
            'data' => new userResource($item_user)
        ],201);
    }
    public function addDeliveryInformation(Request $request)
    {
        $item_user = User::find(auth()->user()->id);
        $newDeliveryInformation = deliveryInformation::create(['name'=>$request->name,'user_id' => $item_user->id,'address' => $request->address,'phone' => $request->phone]);
        return response()->json([
            'code' => 201,
            'data' => new Resource($newDeliveryInformation)
        ],201);
    }
    public function deleteDeliveryInformation(Request $request)
    {
        $itemDeliveryInformation = deliveryInformation::find($request->id);
        deliveryInformation::find($request->id)->delete();
        return response()->json([
            'code' => 201,
            'data' => new Resource($itemDeliveryInformation)
        ],201);
    }
    public function user_login()
    {
        if(auth()->check()){
            return response()->json([
                'code' => 201,
                'data' => new userResource(auth()->user()),
            ]);
        }else{
            return response()->json([
                'code' => 404,
                'message' => 'user not login !'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item_user = User::find($id);
        $image_path = $item_user->image_path;
        if($request->hasFile('image')){
            $file = $request->file('image');
            $image_hash_name = Str::random(20).'.'.$file->extension();
            $store = $file->storeAs('public/user/1',$image_hash_name);
            $image_path = Storage::url($store);
        }
        $item_user->update(['name' => $request->name,'email' => $request->email,'image_path' => $image_path,'phoneNumber' => $request->phoneNumber,'location' => $request->location]);
        $list_role = json_decode($request->roles);
        $roles_id = [];
        $item_user = User::find($id);
        if(!empty($list_role)){
           foreach($list_role as $item_role){
                $roles_id[] = $item_role->id;
            }
            $item_user->role()->sync($roles_id);
        }
        return response()->json([
            'code' => 201,
            'data' => new userResource($item_user)
        ],201);
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json([
            'code' => 201,
            'message' => 'Delete successfully!'
        ],201);
        
    }

    public function sendCodeToEmail(Request $request)
    {
        $userItem = $this->users->where('email',$request->email)->first();
        if($userItem){
            $code = "";
            for($i = 0;$i < 4;$i++){
                $code .= rand(1, 9);
            }
            $userItem->update(['code_get_password' => $code,'expired_code' => Carbon::now('Asia/Ho_Chi_Minh')->addMinutes(2)->toDateTimeString()]);
            $details = [
                'title' => 'Mail from Elecshop',
                'body' => 'This is a password recovery feature via user is email, please do not share this code.',
                'code' => $code
                
            ];
            \Mail::to($request->email)->send(new \App\Mail\sendCodeToEmail($details));
           
            return response()->json([
                'code' => 200,
                'message' => "send code to Email success !"
            ],200);
        }else{
            return response()->json([
                'code' => 404,
                'message' => "Email does not exist !"
            ],404);
        }
        
        
    }

    public function verifyCodeUser(Request $request)
    {
        $userItem = $this->users->where('email',$request->email)->first();
        if($userItem){
            if($userItem->code_get_password == $request->code_get_password){
                return response()->json([
                    'code' => 200,
                    'message' => "Code correct!"
                ],200);
            }else{
                return response()->json([
                    'code' => 404,
                    'message' => "Code not correct !"
                ],404);
            }
        }else{
            return response()->json([
                'code' => 404,
                'message' => "Email does not exist !"
            ],404);
        }
        
        
    }

    public function passwordRetrieval(Request $request)
    {
        $userItem = $this->users->where('email',$request->email)->first();
        if($userItem){
            if($userItem->code_get_password = $request->code_get_password){
                if($userItem->expired_code < Carbon::now('Asia/Ho_Chi_Minh')->toDateTimeString()){
                    return response()->json([
                        'code' => 404,
                        'message' => "Code expire !"
                    ],404);
                }else{
                    if($request->password == $request->password2){
                        $code = "";
                        for($i = 0;$i < 4;$i++){
                            $code .= rand(1, 9);
                        }
                        $userItem->update([
                            'password' => Hash::make($request->password),
                            'code_get_password' => $code
                        ]);
                        return response()->json([
                            'code' => 200,
                            'message' => "Change password success !"
                        ],200);
                    }else{
                        return response()->json([
                            'code' => 403,
                            'message' => "Password incorrect !"
                        ],403);
                    }
                }
            }else{
                return response()->json([
                    'code' => 404,
                    'message' => "Code not correct !"
                ],404);
            }
        }else{
            return response()->json([
                'code' => 404,
                'message' => "Email does not exist !"
            ],404);
        }
        
        
    }
}
