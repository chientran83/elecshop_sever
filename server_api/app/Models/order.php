<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','quantity','price','date','status','method_payment'];
    protected $table = 'tbl_orders';
    protected $primaryKey = 'id';
}
