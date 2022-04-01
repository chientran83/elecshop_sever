<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\productCollection;
use App\Models\product;
use Illuminate\Http\Request;
use App\Http\Resources\v1\productResource;
use App\Models\color;
use App\Models\memory;
use App\Models\tag;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class productController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $product;
    public $tag;
    public $color;
    public $memory;
    public function __construct(product $product,tag $tag,color $color,memory $memory){
        $this->product = $product;
        $this->tag = $tag;
        $this->color = $color;
        $this->memory = $memory;
    }
    public function index()
    {
        return new productCollection($this->product->OrderBy('id','DESC')->get());
    }

    public function pagination()
    {
        return new productCollection($this->product->OrderBy('id','DESC')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        /* $token = $request->header('token');
        $get_session_token = DB::table('tbl_session_token')->where('token',$token)->first();
        if(empty($token)){
            return response()->json([
                'code' => 500,
                'message' => 'token not send !'
            ],500);
        }elseif(empty($get_session_token)){
            return response()->json([
                'code' => 500,
                'message' => 'token incorrect !'
            ],500);
        }else{ */

            $request->validate([
                'name' => 'required|min:1|max:30|unique:tbl_product',
                'current_price' => 'required',
                'previous_price' => 'required',
                'origin_price' => 'required',
                'ram' => 'required',
                'desc' => 'required|min:1',
                'isOnsale' => 'required',
                'quantity' => 'required'
            ]);
            
            $data = array(
                'name' => $request->name,
                'current_price' => $request->current_price,
                'previous_price' => $request->previous_price,
                'origin_price' => $request->origin_price,
                'ram' => $request->ram,
                'desc' => $request->desc,
                'isOnSale' => $request->isOnsale,
                'quantity' => $request->quantity,
                'user_id' => 11,
                'category_id' => json_decode($request->category_id)->id,
                'image_path' => 'default.jpg',
            );

            if($request->hasFile('image')){
                $file = $request->file('image');
                $image_hash_name = Str::random(20).'.'.$file->extension();
                $store = $file->storeAs('public/product/1',$image_hash_name);    
                $data['image_path'] = Storage::url($store);
            }
           
            $product_new = $this->product->create($data);

            foreach(json_decode($request->tags) as $tag_item){
                $new_tag = $this->tag->firstOrcreate(['name' => $tag_item->name]);
                $product_new->tag()->attach($new_tag->id,['price' => $tag_item->price]);
            }
            foreach(json_decode($request->colors) as $color_item){
                $new_color = $this->color->firstOrcreate(['name' => $color_item->name,'code' => $color_item->code]);
                $product_new->color()->attach($new_color,['price' => $color_item->price]);
            }

            foreach(json_decode($request->memory) as $memory_item){
                $new_memory = $this->memory->firstOrcreate(['name' => $memory_item->name]);
                $product_new->memory()->attach($new_memory,['price' => $memory_item->price]);
            }

            foreach(json_decode($request->accessories) as $accessories_item){
                $product_new->accessories()->attach($accessories_item->id);
            }
            
            return response()->json([
                'code' => 201,
                'data' => new productResource($product_new)
            ],201);
        /* } */
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        /* $token = $request->header('token');
        $get_session_token = DB::table('tbl_session_token')->where('token',$token)->first();
        if(empty($token)){
            return response()->json([
                'code' => 500,
                'message' => 'token not send !'
            ],500);
        }elseif(empty($get_session_token)){
            return response()->json([
                'code' => 500,
                'message' => 'token incorrect !'
            ],500);
        }else{ */
            return response()->json([
                'code' => 201,
                'data' => new productResource(product::find($id))
            ],201);
        /* } */
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
        $token = $request->header('token');
        $get_session_token = DB::table('tbl_session_token')->where('token',$token)->first();
        if(empty($token)){
            return response()->json([
                'code' => 500,
                'message' => 'token not send !'
            ],500);
        }elseif(empty($get_session_token)){
            return response()->json([
                'code' => 500,
                'message' => 'token incorrect !'
            ],500);
        }else{
            $request->validate([
                'name' => 'required|min:1|max:30|unique:tbl_product',
                'current_price' => 'required',
                'previous_price' => 'required',
                'origin_price' => 'required',
                'ram' => 'required',
                'desc' => 'required|min:1',
                'isOnSale' => 'required',
                'quantity' => 'required',
                'user_id' => 'required',
            ]);
    
            $data = array(
                'name' => $request->name,
                'current_price' => $request->current_price,
                'previous_price' => $request->previous_price,
                'origin_price' => $request->origin_price,
                'ram' => $request->ram,
                'desc' => $request->desc,
                'isOnSale' => $request->isOnSale,
                'quantity' => $request->quantity,
                'user_id' => '1',
                'image_path' => 'test duong dan anh',
            );
            /* if($request->hasFile('image')){
                $file = $request->file('image');
                $image_origin_name = $file->getClientOriginalName();
                $image_hash_name = Str::random(20).'.'.$file->extension();
                $store = $file->storeAs('public/product/1',$image_hash_name);            
                $data['image_name'] = $image_origin_name;
                $data['image_path'] = Storage::url('file.jpg');
            }   */
    
            $this->product->find($id)->update($data);
            $product_update = $this->product->find($id);
            return response()->json([
                'code' => 201,
                'data' => new productResource($product_update)
            ],201);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $token = $request->header('token');
        $get_session_token = DB::table('tbl_session_token')->where('token',$token)->first();
        if(empty($token)){
            return response()->json([
                'code' => 500,
                'message' => 'token not send !'
            ],500);
        }elseif(empty($get_session_token)){
            return response()->json([
                'code' => 500,
                'message' => 'token incorrect !'
            ],500);
        }else{
            $product_item = $this->product->find($id);
            $this->product->find($id)->delete();
            return new productResource($product_item);
                return response()->json([
                    'code' => 201,
                    'data' => new productResource($product_item)
            ],201);
        }
        
    }
}
