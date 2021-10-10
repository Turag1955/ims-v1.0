<?php

namespace Modules\System\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Support\Facades\Cache;


class unit extends BaseModel
{
   
    protected $unit_name;
    protected $fillable = ['unit_code','unit_name','base_unit','operator','operation_value','status','crated_by','updated_by'];

    public function setUnitName($unit_name)
    {
        $this->unit_name = $unit_name;
    }
    
    public function baseUnit()
    {
        return $this->belongsTo(unit::class,'base_unit','id')->withDefault(['unit_name'=>'N/A']);
    }

    protected function get_data_table_query()
    {
        if (permission('unit-bulk-delete')) {
            $this->column_order = [null, 'id','unit_code','unit_name','base_unit','operator','operation_value','status', null];
        } else {
            $this->column_order = ['id','unit_code','unit_name','base_unit','operator','operation_value','status', null];

        }
        $query = self::with('baseUnit');
        if (!empty($this->unit_name)) {
            $query->where('unit_name', 'like', '%' . $this->unit_name . '%');
        }
        if (isset($this->orderValue) && isset($this->dirValue)) {
            $query->orderBy($this->column_order[$this->orderValue], $this->dirValue);
        } else {
            $query->orderBy('id', 'desc');
        }
        return $query;
    }

    public function get_dataTable()
    {
        $query = $this->get_data_table_query();
        if ($this->length != -1) {
            $query->offset($this->start)->limit($this->length);
        }
        return $query->get();
    }

    public function totalField()
    {
        return self::toBase()->get()->count();
    }

    public function totalFilter()
    {
        $query = $this->get_data_table_query();

        return   $query->get()->count();
    }

    /**********
     * Cache Dataa
     *********/

    private const ALL_CUSTOMER_GROUP = '_all_customer_group';
    private const ACTIVE_CUSTOMER_GROUP = '_active_customer_group';

    public static function allCustomerGroup(){
        return Cache::rememberForever(self::ALL_CUSTOMER_GROUP, function () {
            return self::toBase()->get();
        });
    }

    public static function activeCustomerGroup(){
        return Cache::rememberForever(self::ACTIVE_CUSTOMER_GROUP, function () {
           return self::toBase()->where('status','1')->get();
        });
    }
   public static function flushCache(){
       Cache::forget(self::ALL_CUSTOMER_GROUP);
       Cache::forget(self::ACTIVE_CUSTOMER_GROUP);
   }

   public static function boot(){
       parent::boot();

       static::created(function(){
           self::flushCache();
       });
       static::updated(function(){
           self::flushCache();
       });
       static::deleted(function(){
           self::flushCache();
       });
   }

//    public function statusFun()
//    {
//        $query = self::toBase();
//        return $query->where('status','1')->get();
//    }

    
    
}
