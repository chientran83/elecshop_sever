<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = ['user_id','quantity','price','date','status','method_payment'];
    protected $table = 'tbl_orders';
    protected $primaryKey = 'id';

    public function product(){
        return $this->belongsToMany(product::class,'tbl_order_product','order_id','product_id');
    }
}
