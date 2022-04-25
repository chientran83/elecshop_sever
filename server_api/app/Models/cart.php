<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','quantity','memory_id','tag_id','color_id'];
    protected $table = 'tbl_carts';
    protected $primaryKey = 'id';

    public function product(){
        return $this->belongsToMany(product::class,'tbl_cart_product','cart_id','product_id')->withPivot('quantity');
    }
}
