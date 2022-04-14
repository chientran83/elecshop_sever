<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Collection;
use App\Http\Resources\v1\userCollection;
use App\Http\Resources\v1\userResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class userController extends Controller
{
    public function __construct() {

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($record_number)
    {
        return new userCollection(User::paginate($record_number));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
            $new_user = User::create(['name' => $request->name,'email' => $request->email,'password' => Hash::make( $request->password),'image_path' => $image_path]);
            $list_role = json_decode($request->roles);
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

    public function logout(Request $request)
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        $item_user->update(['name' => $request->name,'email' => $request->email,'image_path' => $image_path]);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json([
            'code' => 201,
            'message' => 'Delete successfully!'
        ],201);
        
    }
}
