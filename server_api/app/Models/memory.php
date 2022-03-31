<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class memory extends Model
{
    use HasFactory;
    protected $fillable = ['name'];
    protected $table = 'tbl_memories';
    protected $primaryKey = 'id';
}
