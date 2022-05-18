<?php

namespace App\Exports;

use App\Models\order;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class orderExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($sort){
        $this->sort = $sort;
    }
    public function collection()
    {
        if($this->sort == 'all'){
            return order::get();
        }else if($this->sort == 'waitAccept'){
            return order::where('status',0)->get();
        }else if($this->sort == 'productSent'){
            return order::whereIn('status',[2,3])->get();
        }else if($this->sort == 'success'){
            return order::where('status',3)->get();
        }else{
            return false;
        }
    }
    public function headings() :array
    {
        return ["id", "user_id", "product_id","coupon_id", "price_total","deliveryinformation_id","quantity", "method_payment","color_id","tags_id","memory_id","date","status","created_at","updated_at",];
    }
}
