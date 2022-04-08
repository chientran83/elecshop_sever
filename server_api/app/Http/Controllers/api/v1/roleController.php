<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Collection;
use App\Http\Resources\v1\roleCollection;
use App\Http\Resources\v1\roleResource;
use App\Models\permission;
use App\Models\resource;
use App\Models\role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class roleController extends Controller
{
    public $role;
    public $permission;
    public $resource;
    public function __construct(role $role,permission $permission,resource $resource){
        // $this->middleware('auth:api',['except' => ['index','show']]);
        $this->role = $role;
        $this->permission = $permission;
        $this->resource = $resource;
    }

    public function store(Request $request){
        $new_role = $this->role->create(['name' => $request->name,'desc' => $request->desc,'status' => $request->status]);
        if(!empty(json_decode($request->permissions))){
            foreach(json_decode($request->permissions) as $permission_id){
                $get_permission = DB::table('tbl_permissions')->where('id',$permission_id)->first();
                $new_role->resource()->attach($get_permission->resource_id,['allow' => $get_permission->allow]);
            }
        }
        return response()->json([
            'code' => 200,
            'data' => new roleResource($new_role)
        ],200);
    }
    public function update(Request $request,$id){
        $this->role->find($id)->update(['name' => $request->name,'desc' => $request->desc,'status' => $request->status]);
        $item_role = $this->role->find($id);
        foreach($item_role->resource as $itemResource){
            DB::table('tbl_permissions')->where('role_id',$item_role->id)->where('resource_id',$itemResource->id)->delete();
        }
        if(!empty(json_decode($request->permissions))){
            foreach(json_decode($request->permissions) as $permission_id){
                $get_permission = DB::table('tbl_permissions')->where('id',$permission_id)->first();
                $item_role->resource()->attach($get_permission->resource_id,['allow' => $get_permission->allow]);
            }
        }
        $item_role = $this->role->find($id);
        return response()->json([
            'code' => 200,
            'data' => new roleResource($item_role)
        ],200);
    }
    public function show($id)
    {
        $role_item = $this->role->find($id);
        return new roleResource($role_item);
    }
    public function index($record_number){
        $list_role = $this->role->paginate($record_number);
        if(empty($list_role)){
            return response()->json([
                'code' => 422,
                'message' => 'empty data!'
            ],422);
        }
        return new roleCollection($list_role);
    }
    public function destroy($id)
    {
        $role_item = $this->role->find($id);
        $role_item->permission()->delete();
        $this->role->find($id)->delete();
        return new roleResource($role_item);
    }



}
