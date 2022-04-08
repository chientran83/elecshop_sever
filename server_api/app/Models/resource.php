<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class resource extends Model
{
    use HasFactory;
    protected $fillable = ['alias'];
    protected $table = 'tbl_resources';
    protected $primaryKey = 'id';

    public function permissionDefault(){
        return $this->hasMany(permission::class,'resource_id')->where('role_id',0);
    }
    public function permission(){
        return $this->hasMany(permission::class,'resource_id')->where('role_id','<>',0);
    }
}
