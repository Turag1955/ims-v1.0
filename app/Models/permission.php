<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class permission extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['module_id', 'name', 'slug'];

    public function module(){
        return $this->belongsTo(Module::class);
    }

    public function permission_role(){
        return $this->hasMany(permission_role::class);
    }
}
