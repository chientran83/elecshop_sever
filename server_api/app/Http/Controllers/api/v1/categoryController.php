<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\category_product_desc_Resource;
use App\Http\Resources\v1\categoryCollection;
use App\Models\category;
use Illuminate\Http\Request;
use App\Http\Resources\v1\categoryResource;

class categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $category;
    public function __construct(category $category){
        $this->category = $category;
        
    }
    public function index()
    {
        return new categoryCollection($this->category->orderBy('id','DESC')->get());
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
            'name' => 'required|min:1|unique:tbl_category',
            'desc' => 'required'
        ]);
        $data = array(
            'name' => $request->name,
            'desc' => $request->desc
        );
        $category_new = $this->category->create($data);
        return new categoryResource($category_new);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if($request->sortByPrice == "desc"){
            return new category_product_desc_Resource($this->category->find($id));
        }else{
            return new categoryResource($this->category->find($id));
        }
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
        $category_item = $this->category->find($id);
        $request->validate([
            'name' => 'required|min:1|unique:tbl_category,name,'.$category_item->id,
            'desc' => 'required'
        ]);
        $data = array(
            'name' => $request->name,
            'desc' => $request->desc
        );
        $this->category->find($id)->update($data);
        $category_item = $this->category->find($id);
        return new categoryResource($category_item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category_item = $this->category->find($id);
        $this->category->find($id)->delete();
        return new categoryResource($category_item);
    }
}
