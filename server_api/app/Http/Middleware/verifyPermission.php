<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class verifyPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,$resource,$permission)
    {
/*         return response()->json([
            'code' => 401,
            'message' => $resource . " " . $permission
        ],422); */
        $result_check = false;
        if(auth()->check()){
            $user_login = auth()->user();
            foreach($user_login->role as $item_role){
                foreach($item_role->resource as $item_resource){
                    if($item_resource->alias == $resource){
                        $get_permission = DB::table('tbl_permissions')->where('role_id',$item_role->id)->where('resource_id',$item_resource->id)->where('allow',$permission)->first();
                        if(!empty($get_permission)){
                            $result_check = true;
                        }
                    }
                }
            }
        }
        if($result_check){
            return $next($request);
        }else{
            return response()->json([
                'code' => 401,
                'message' => "unauthorized"
            ],422);
        }
    }
}
