<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Resource as V1Resource;
use App\Models\resource;
use Illuminate\Http\Request;

class resourceController extends Controller
{
    public $resource;
    public function __construct(resource $resource){
        $this->resource = $resource;
    }

    public function store(Request $request){
        $new_resource = $this->resource->create(['alias' => $request->alias]);
        return response()->json([
            'code' => 200,
            'data' => new V1Resource($new_resource)
        ],200);
    }

}
