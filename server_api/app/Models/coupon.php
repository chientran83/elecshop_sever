<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class coupon extends Model
{
    use HasFactory;
    protected $fillable = ['expire','code','type','value'];
    protected $table = 'tbl_coupons';
    protected $primaryKey = 'id';
}
