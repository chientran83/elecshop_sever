<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\resourcesResource;
use App\Http\Resources\v1\resourcesCollection;
use App\Models\permission;
use App\Models\resource;
use Illuminate\Http\Request;

class resourceController extends Controller
{
    public $resource;
    public $permission;
    public function __construct(resource $resource,permission $permission){
        $this->resource = $resource;
        $this->permission = $permission;
    }

    public function store(Request $request){
        $new_resource = $this->resource->create(['alias' => $request->alias]);
        if(!empty(json_decode($request->permissions))){
            foreach(json_decode($request->permissions) as $item_permission){
                $this->permission->create(['allow' => $item_permission->name,'resource_id' => $new_resource->id]);
            }
        }
        return response()->json([
            'code' => 200,
            'data' => new resourcesResource($new_resource)
        ],200);
    }
    public function index($record_number){
        if($record_number == 0){
            $list_resource = $this->resource->all();

        }else{
            $list_resource = $this->resource->paginate($record_number);

        }
        return new resourcesCollection($list_resource);
    }
    public function show($id){
        $item_resource = $this->resource->find($id);
        return new resourcesResource($item_resource);
    }
    public function update(Request $request,$id){
        $this->resource->find($id)->update(['alias' => $request->alias]);
        $item_resource = $this->resource->find($id);

        if(!empty(json_decode($request->permissions))){
            $list_permisison = collect(json_decode($request->permissions));
            foreach($item_resource->permissionDefault as $item_permission){
                if( $list_permisison->contains('name',$item_permission->allow)){

                }else{
                    $this->permission->find($item_permission->id)->delete();
                }
            }

            foreach(json_decode($request->permissions) as $item_permission){
                $list_permisison = collect($item_resource->permissionDefault);
                if($list_permisison->contains('allow',$item_permission->name)){

                }else{
                    $this->permission->create(['allow' => $item_permission->name,'resource_id' => $item_resource->id]);
                }
            }
        }else{
            $item_resource->permissionDefault()->delete();
        }
        $item_resource = $this->resource->find($id);
        return response()->json([
            'code' => 200,
            'data' => new resourcesResource($item_resource)
        ],200);
    }
    public function delete($id){
        $resource = $this->resource->find($id);
        $item_resource = $this->resource->find($id);
        $item_resource->permissionDefault()->delete();
        $this->resource->find($id)->delete();
        return new resourcesResource($resource);
    }

}
