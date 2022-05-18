<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $fillable = ['id','user_id','product_id','coupon_id','price_total','deliveryInformation_id','quantity','method_payment','color_id','tags_id','memory_id','date','status'];
    protected $table = 'tbl_orders';
    protected $primaryKey = 'id';
}
