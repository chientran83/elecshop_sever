<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $fillable = ['name','current_price','previous_price','origin_price','image_path','ram','desc','quantity','isOnSale','user_id'];
    protected $table = 'tbl_product';
    protected $primaryKey = 'id';
   /*  public function color(){
        return $this->belongsToMany('');
    } */
};