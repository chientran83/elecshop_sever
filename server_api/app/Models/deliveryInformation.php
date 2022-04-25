<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deliveryInformation extends Model
{
    use HasFactory;
    protected $fillable = ['name','user_id','address','phone'];
    protected $table = 'tbl_delivery_information';
    protected $primaryKey = 'id';
}
