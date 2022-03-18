<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;
    protected $fillable = ['name','desc'];
    protected $table = 'tbl_category';
    protected $primary = 'id';

    public function product(){
        return $this->belongsToMany(product::class,'tbl_product_category','category_id','product_id')->orderBy('id','ASC');
    }
    public function product_desc(){
        return $this->belongsToMany(product::class,'tbl_product_category','category_id','product_id')->orderBy('id','DESC');
    }
}
