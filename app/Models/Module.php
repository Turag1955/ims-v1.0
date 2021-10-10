<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TypiCMS\NestableTrait;


class Module extends Model
{
    use HasFactory;
    use NestableTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['menu_id', 'type', 'module_name', 'devider_name', 'icon_class', 'url', 'order', 'parent_id', 'target'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function parent()
    {
        return $this->belongsTo(Module::class,'parent_id','id');
    }

    public function children()
    {
        return $this->hasMany(Module::class,'parent_id','id')->orderBy('order','asc');
    }
    
    public function permission()
    {
        return $this->hasMany(permission::class);
    }

    public function submenu()
    {
        return $this->hasMany(Module::class,'parent_id','id')
                     ->with('permission');
    }

    public function module_role(){
        return $this->hasMany(module_role::class);
    }
}
