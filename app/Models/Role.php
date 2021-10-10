<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['role_name','deletable'];

    public function module_role(){
        return $this->belongsToMany(Module::class);
    }

    public function permission_role(){
        return $this->belongsToMany(permission::class);
    }

    public function users(){
        return $this->hasMany(User::class);
    }
}
