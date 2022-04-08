<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class permission extends Model
{
    use HasFactory;
    protected $fillable = ['allow','role_id','resource_id'];
    protected $table = 'tbl_permissions';
    protected $primaryKey = 'id';
}
