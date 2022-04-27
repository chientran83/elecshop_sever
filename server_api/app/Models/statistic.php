<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class statistic extends Model
{
    use HasFactory;
    protected $fillable = ['date','profit','quantitySold','quantityPurchased','newUser','paymentOnline','paymentLater'];
    protected $table = 'tbl_statistics';
    protected $primaryKey = 'id';
}
