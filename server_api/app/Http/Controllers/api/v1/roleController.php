<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\roleResource;
use App\Models\permission;
use App\Models\role;
use Illuminate\Http\Request;

class roleController extends Controller
{
    public $role;
    public $permission;
    public function __construct(role $role,permission $permission){
        $this->role = $role;
        $this->permission = $permission;
    }

    public function store(Request $request){
        $new_role = $this->role->create(['name' => $request->name,'desc' => $request->desc,'status' => $request->status]);
        $arr_permissions = [];
        foreach( $request->permissions as $permission){
            $arr_permissions[] = $permission;
        }
        $new_role->permission()->attach($arr_permissions);
        return response()->json([
            'code' => 200,
            'data' => new roleResource($new_role)
        ],200);
    }


}
