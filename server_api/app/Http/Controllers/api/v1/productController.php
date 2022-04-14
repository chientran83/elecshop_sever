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
use Illuminate\Support\Facades\File;
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
    public $tags;
    public $color;
    public $memory;
    public function __construct(product $product,tag $tags,color $color,memory $memory){
        $this->product = $product;
        $this->tags = $tags;
        $this->color = $color;
        $this->memory = $memory;
    }
    public function index($record_number)
    {
        if($record_number == 0){
            return new productCollection($this->product->OrderBy('id','DESC')->all());
        }else{
            return new productCollection($this->product->OrderBy('id','DESC')->paginate($record_number));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
                'tag' => $request->tag,
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

            if($request->tags){
                foreach(json_decode($request->tags) as $tag_item){
                    $new_tag = $this->tags->firstOrcreate(['name' => $tag_item->name]);
                    $product_new->tags()->attach($new_tag->id,['price' => $tag_item->price]);
                }

            }
            if($request->colors){
                foreach(json_decode($request->colors) as $key => $color_item){
                    $arr = array(
                        'name' => $color_item->name,
                        'code' => $color_item->codes,
                        'price'=> $color_item->price,
                        'product_id'=>$product_new->id
                    );
                    if($request->hasFile('file'.$key)){
                        $file = $request->file('file'.$key);
                        $image_hash_name = Str::random(20).'.'.$file->extension();
                        $store = $file->storeAs('public/productImageColor/2',$image_hash_name);
                        $arr['image_path'] =  Storage::url($store);
                    }
                    $this->color->create($arr);
                }
            }
            if($request->memory){
                foreach(json_decode($request->memory) as $memory_item){
                    $new_memory = $this->memory->firstOrcreate(['name' => $memory_item->name]);
                    $product_new->memory()->attach($new_memory,['price' => $memory_item->price]);
                }

            }
            if($request->accessories){
                foreach(json_decode($request->accessories) as $accessories_item){
                    $product_new->accessories()->attach($accessories_item->id);
                }

            }
            
            return response()->json([
                'code' => 201,
                'data' => new productResource($product_new)
            ],201);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
            return response()->json([
                'code' => 201,
                'data' => new productResource(product::find($id))
            ],201);
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
            $product_item= $this->product->find($id);
            $request->validate([
                'name' => 'required|min:1|max:30|unique:tbl_product,name,'.$product_item->id,
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
                'tag' => $request->tag,
                'desc' => $request->desc,
                'isOnSale' => $request->isOnsale,
                'quantity' => $request->quantity,
                'user_id' => 11,
                'category_id' => json_decode($request->category_id)->id
            );

            if($request->hasFile('image')){
                if(File::exists($product_item->image_path)) {
                    File::delete($product_item->image_path);
                }
                $file = $request->file('image');
                $image_hash_name = Str::random(20).'.'.$file->extension();
                $store = $file->storeAs('public/product/1',$image_hash_name);    
                $data['image_path'] = Storage::url($store);
            }

            $this->product->find($id)->update($data);

            $product_item= $this->product->find($id);
            $product_item->tags()->delete();
            foreach(json_decode($request->tags) as $tag_item){
                $new_tag = $this->tags->firstOrcreate(['name' => $tag_item->name]);
                $product_item->tags()->attach($new_tag->id,['price' => $tag_item->pivot->price]);
            }

            if($request->colors){
                foreach($this->product->find($id)->color as $value){
                    $abc = json_decode($request->colors);
                    $collection = collect($abc);
                    if($collection->contains('name',$value->name)){
                        
                    }else{
                        $this->color->find($value->id)->delete();
                    }
                    
                }
                foreach(json_decode($request->colors) as $key => $color_item){
                    $product_color = $this->color->where('name', $color_item->name)->first();
                    if($product_color){
                        $arr = array(
                            'name' => $color_item->name,
                            'code' => $color_item->codes,
                            'price'=> $color_item->price
                        );
                        if($request->hasFile('file'.$key)){
                            $file = $request->file('file'.$key);
                            $image_hash_name = Str::random(20).'.'.$file->extension();
                            $store = $file->storeAs('public/productImageColor/2',$image_hash_name);
                            $arr['image_path'] =  Storage::url($store);
                        }
                        $product_color->update($arr);
                    }else{

                        $arr = array(
                            'name' => $color_item->name,
                            'code' => $color_item->codes,
                            'price'=> $color_item->price,
                            'product_id'=>$product_item->id
                        );
                        if($request->hasFile('file'.$key)){
                            $file = $request->file('file'.$key);
                            $image_hash_name = Str::random(20).'.'.$file->extension();
                            $store = $file->storeAs('public/productImageColor/2',$image_hash_name);
                            $arr['image_path'] =  Storage::url($store);
                        }
                        $this->color->create($arr);
                    }
                }
            }

            $product_item->memory()->delete();
            foreach(json_decode($request->memory) as $memory_item){
                $new_memory = $this->memory->firstOrcreate(['name' => $memory_item->name]);
                $product_item->memory()->attach($new_memory,['price' => $memory_item->pivot->price]);
            }

            $accessories = [];
            foreach(json_decode($request->accessories) as $accessories_item){
                $accessories[] = $accessories_item->id;
            }
            $product_item->accessories()->sync($accessories);

            $product_update = $this->product->find($id);
            return response()->json([
                'code' => 201,
                'data' => new productResource($product_update)
            ],201);
        /* } */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
            $product_item = $this->product->find($id);
            $this->product->find($id)->delete();
            return new productResource($product_item);
                return response()->json([
                    'code' => 201,
                    'data' => new productResource($product_item)
            ],201);
        }
}
