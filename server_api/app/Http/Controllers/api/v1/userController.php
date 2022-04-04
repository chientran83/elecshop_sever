<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Collection;
use App\Http\Resources\v1\userResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class userController extends Controller
{
    public function __construct() {
       /*  $this->middleware('auth:api', ['except' => ['login', 'store','paginate']]); */
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function paginate()
    {
        return new Collection(User::paginate(6));
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
        $image_path = "";
        if($request->hasFile('image')){
            $file = $request->file('image');
            $image_hash_name = Str::random(20).'.'.$file->extension();
            $store = $file->storeAs('public/user/1',$image_hash_name);    
            $image_path = Storage::url($store);
        }
        $new_user = User::create(['name' => $request->name,'email' => $request->email,'password' => Hash::make( $request->password),'image_path' => $image_path]);
        if(empty($new_user)){
            return response()->json([
                'code' => 500,
                'message' => 'register error!'
            ],500);
        }else{
            return response()->json([
                'code' => 201,
                'data' => new userResource($new_user)
            ],201);
        }
    }
    public function login(Request $request)
    {
        if(! $token = auth()->attempt(['email' => $request->email,'password' => $request->password])){  
            return response()->json([
                'code' => 500,
                'message' => 'email or password incorrect!'
            ],500);
        }else{
            return $this->createNewToken($token);
        }
    }
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
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
            ],201);
        }else{
            return response()->json([
                'code' => 201,
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
        $item_user = User::find($id);
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
