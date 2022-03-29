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
        return $this->belongsToMany(permission::class,'tbl_role_permission','role_id','permission_id');
    }

}
