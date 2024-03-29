<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $fillable = ['name','current_price','previous_price','origin_price','image_path','ram','desc','quantity','isOnSale','user_id','category_id','tag'];
    protected $table = 'tbl_product';
    protected $primaryKey = 'id';
    public function color(){
        return $this->hasMany(color::class,'product_id');
    }
    public function tags(){
        return $this->belongsToMany(tag::class,'tbl_product_tag','product_id','tag_id')->withPivot('price');
    }
    public function memory(){
        return $this->belongsToMany(memory::class,'tbl_product_memory','product_id','memory_id')->withPivot('price');
    }
    public function category(){
        return $this->belongsTo(category::class,'category_id');
    }
    public function accessories(){
        return $this->belongsToMany(product::class,'tbl_product_accessories','product_primary','product_secondary');
    }
};