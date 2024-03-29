<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class slider extends Model
{
    use HasFactory;
    protected $fillable = ['name','desc','image_path','status','link','linkInformation','product_id'];
    protected $table = 'tbl_slider';
    protected $primaryKey = 'id';

    public function product(){
        return $this->belongsTo(product::class,'product_id');
    }
}
