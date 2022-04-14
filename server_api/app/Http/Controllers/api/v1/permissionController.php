<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\permission;
use Illuminate\Http\Request;

class permissionController extends Controller
{
    public $permission;
    public function __construct(permission $permission){
        $this->permission = $permission;
    }
    public function store(Request $request){
        $new_permission = $this->permission->create([
            'name' => $request->name,
            'key_code' => $request->key_code,
            'resource_id' => $request->resource_id]);
        return response()->json([
            'code' => 200,
            'data' => $new_permission
        ],200);
    }
}
