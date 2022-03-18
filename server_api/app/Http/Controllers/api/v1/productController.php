<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\productCollection;
use App\Models\product;
use Illuminate\Http\Request;
use App\Http\Resources\v1\productResource;
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
    public function __construct(product $product){
        $this->product = $product;
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
        $request->validate([
            'name' => 'required|min:1|max:30|unique:tbl_product',
            'current_price' => 'required',
            'origin_price' => 'required',
            'memory' => 'required',
            'ram' => 'required',
            'sale_date' => 'required',
            'desc' => 'required|min:1',
            'coupon_number' => 'required',
            'quantity' => 'required',
            'user_id' => 'required',
        ]);
        $data = array(
            'name' => $request->name,
            'current_price' => $request->current_price,
            'origin_price' => $request->origin_price,
            'memory' => $request->memory,
            'ram' => $request->ram,
            'sale_date' => $request->sale_date,
            'desc' => $request->desc,
            'coupon_number' => $request->coupon_number,
            'quantity' => $request->quantity,
            'user_id' => '1',
            'image_name' => 'test ten anh',
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
        $product_new = $this->product->create($data);
        return new productResource($product_new);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new productResource($this->product->find($id));
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
        $request->validate([
            'name' => 'required|min:1|max:30|unique:tbl_product',
            'current_price' => 'required',
            'origin_price' => 'required',
            'memory' => 'required',
            'ram' => 'required',
            'sale_date' => 'required',
            'desc' => 'required|min:1',
            'coupon_number' => 'required',
            'quantity' => 'required',
            'user_id' => 'required',
        ]);

        $data = array(
            'name' => $request->name,
            'current_price' => $request->current_price,
            'origin_price' => $request->origin_price,
            'memory' => $request->memory,
            'ram' => $request->ram,
            'sale_date' => $request->sale_date,
            'desc' => $request->desc,
            'coupon_number' => $request->coupon_number,
            'quantity' => $request->quantity,
            'user_id' => '1',
            'image_name' => 'test ten anh',
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
        return new productResource($product_update);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product_item = $this->product->find($id);
        $this->product->find($id)->delete();
        return new productResource($product_item);
    }
}
