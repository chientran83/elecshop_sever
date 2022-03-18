<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $fillable = ['name','current_price','origin_price','image_name','image_path','memory','ram','sale_date','desc','coupon_number','quantity','user_id'];
    protected $table = 'tbl_product';
    protected $primaryKey = 'id';
};