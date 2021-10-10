<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['menu_name','deletable'];

    public function menuItem()
    {
        return $this->hasMany(Module::class)->doesntHave('parent')->orderBy('order','asc');
    }
}
