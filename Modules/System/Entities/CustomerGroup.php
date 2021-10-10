<?php

namespace Modules\System\Entities;

use Modules\Base\Entities\BaseModel;
use Illuminate\Support\Facades\Cache;



class CustomerGroup extends BaseModel
{

    protected $group_name;
    
    protected $fillable = ['group_name', 'parcentage', 'status', 'created_by', 'updated_by'];

    public function setName($group_name)
    {
        $this->group_name = $group_name;
    }

    protected function get_data_table_query()
    {
        if (permission('customer-group-bulk-delete')) {
            $this->column_order = [null, 'id', 'group_name', 'parcentage', 'status', null];
        } else {
            $this->column_order = ['id', 'group_name', 'parcentage', 'status', null];
        }
        $query = self::toBase();
        if (!empty($this->group_name)) {
            $query->where('group_name', 'like', '%' . $this->group_name . '%');
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

   public function statusFun()
   {
       $query = self::toBase();
       return $query->where('status','1')->get();
   }

}
