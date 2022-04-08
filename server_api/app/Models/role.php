<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = ['name','desc','status'];
    protected $table = 'tbl_roles';
    protected $primaryKey = 'id';

    public function permission(){
        return $this->hasMany(permission::class,'role_id');
    }
    public function resource(){
        return $this->belongsToMany(resource::class,'tbl_permissions','role_id','resource_id');
    }

}
