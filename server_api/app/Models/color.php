<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class color extends Model
{
    use HasFactory;
    protected $fillable = ['name','code'];
    protected $table = 'tbl_colors';
    protected $primaryKey = 'id';
}
