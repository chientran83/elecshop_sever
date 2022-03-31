<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $new_user = User::create(['name' => $request->name,'email' => $request->email,'password' => Hash::make( $request->password)]);
        if(empty($new_user)){
            return response()->json([
                'code' => 500,
                'message' => 'register error!'
            ],500);
        }else{
            return response()->json([
                'code' => 201,
                'data' => $new_user
            ],201);
        }
    }
    public function login(Request $request)
    {
        if(auth()->attempt(['email' => $request->email,'password' => $request->password])){
            $user_login = User::where('email', $request->email)->first();
            $get_session_token = DB::table('tbl_session_token')->where('user_id',$user_login->id)->first();
            if(empty($get_session_token)){
                DB::table('tbl_session_token')->insert([
                    'token' => Str::random(40),
                    'expire_token' => date('Y-m-d', strtotime(' + 7 days')),
                    'user_id' => $user_login->id
                ]);
                $token = DB::table('tbl_session_token')->where('user_id',$user_login->id)->first();
                // set cookie
                /* $time = date('Y-m-d', strtotime(' + 1 days'));
                Cookie::queue('name', 'value', $time); */
                return response()->json([
                    'code' => 201,
                    'data' => $token
                ],201);
            }else{
                return response()->json([
                    'code' => 201,
                    'data' => $get_session_token
                ],201);
            }
        }else{
            return response()->json([
                'code' => 500,
                'message' => 'email or password incorrect!'
            ],500);
        }
    }
    public function checkLogin()
    {
        if(auth()->check()){
            return response()->json([
                'code' => 201,
                'message' => 'login!'
            ],201);
            
        }else{
            return response()->json([
                'code' => 201,
                'message' => 'not login!'
            ],201);

        }
    }
    public function logout(Request $request)
    {
        auth()->logout();
        return response()->json([
            'code' => 201,
            'message' => 'logout success!'
        ],201);
    }
    public function delete_token(Request $request)
    {
        $token = $request->header('token');
        $get_session_token = DB::table('tbl_session_token')->where('token', $token)->first();
        if(empty($token)){
            return response()->json([
                'code' => 500,
                'message' => 'token not send'
            ],500);
        }else if(empty($get_session_token)){
            return response()->json([
                'code' => 500,
                'message' => 'token incorrect'
            ],500);
        }else{
            DB::table('tbl_session_token')->where('token', $token)->delete();
            return response()->json([
                'code' => 201,
                'message' => 'delete token success !'
            ],201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
