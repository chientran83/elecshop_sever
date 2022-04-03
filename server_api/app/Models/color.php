<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class color extends Model
{
    use HasFactory;
    protected $fillable = ['name','code','price','image_path','product_id'];
    protected $table = 'tbl_colors';
    protected $primaryKey = 'id';

   /*  public function image_path(){
        return $this->hasMany();
    } */
}
