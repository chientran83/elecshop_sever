<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\Collection;
use App\Http\Resources\v1\Resource;
use App\Models\coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class couponController extends Controller
{
    public $coupon;
    public function __construct(coupon $coupon){
        $this->coupon = $coupon;
    }
    
    public function index($record_number)
    {
        /* if(!empty($record_number)){
            return new Resource($this->coupon->paginate($record_number));
        } */
        return new Collection ($this->coupon->paginate($record_number));
    }
    public function store(Request $request)
    {
        $data = array(
            'code' => $request->code,
            'expire' => $request->expire,
            'type' => $request->type,
            'value' => $request->value

        );
        $coupon_new = $this->coupon->create($data);
        return new Resource($coupon_new);
    }

 
    public function show($id)
    {
        return new Resource($this->coupon->find($id));
    }

 
    public function update(Request $request, $id)
    {
        $data = array(
            'code' => $request->code,
            'expire' => $request->expire,
            'type' => $request->type,
            'value' => $request->value
        );
        $this->coupon->find($id)->update($data);
        $coupon_item = $this->coupon->find($id);
        return new Resource($coupon_item);
    }

 
    public function destroy($id)
    {
        $coupon_item = $this->coupon->find($id);
        $this->coupon->find($id)->delete();
        return new Resource($coupon_item);
    }
}
