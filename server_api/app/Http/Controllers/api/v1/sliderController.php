<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\sliderCollection;
use App\Models\slider;
use Illuminate\Http\Request;
use App\Http\Resources\v1\sliderResource;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class sliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $slider;
    public function __construct(slider $slider){
        $this->slider = $slider;
    }
    public function index($record_number)
    {
        if($record_number == 0){
            return new sliderCollection($this->slider->where('status','<>',0)->get());
            
        }else{
            return new sliderCollection($this->slider->where('status','<>',0)->paginate($record_number));
            
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
            'name' => 'required|min:1|unique:tbl_slider',
            'desc' => 'required'
        ]);
        $data = array(
            'name' => $request->name,
            'link' => $request->link,
            'desc' => $request->desc,
            'status' => $request->status,
            'image_path' => 'https://i.ytimg.com/vi/8IM82rdy3Dc/maxresdefault.jpg'
        );
        if($request->hasFile('image')){
            $file = $request->file('image');
            $image_hash_name = Str::random(20).'.'.$file->extension();
            $store = $file->storeAs('public/slider/1',$image_hash_name);
            $data['image_path'] = Storage::url($store);
        }
        $slider_new = $this->slider->create($data);
        return new sliderResource($slider_new);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new sliderResource($this->slider->find($id));
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
        $slider_item = $this->slider->find($id);
        $request->validate([
            'name' => 'required|min:1|unique:tbl_slider,name,'.$slider_item->id,
            'desc' => 'required'
        ]);
        $data = array(
            'name' => $request->name,
            'desc' => $request->desc,
            'link' => $request->link,
            'status' => $request->status
        );
        if($request->hasFile('image')){
            $file = $request->file('image');
            $image_hash_name = Str::random(20).'.'.$file->extension();
            $store = $file->storeAs('public/product/1',$image_hash_name);
            $data['image_path'] = Storage::url($store);
        }  
        $this->slider->find($id)->update($data);
        $slider_item = $this->slider->find($id);
        return new sliderResource($slider_item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $slider_item = $this->slider->find($id);
        $this->slider->find($id)->delete();
        return new sliderResource($slider_item);
    }
}
