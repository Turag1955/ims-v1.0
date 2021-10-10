<?php

namespace Modules\Category\Entities;

use Modules\Base\Entities\BaseModel;




class Category extends BaseModel
{
    protected $fillable = ['name', 'status', 'crated_by', 'updated_by'];

    protected $name;

    protected function setName($name)
    {
        $this->name = $name;
    }

    protected function get_data_table_query()
    {
        if (permission('category-bulk-delete')) {
            $this->column_order = ['id', 'name', 'status', null];
        }else{
            $this->column_order = [null,'id', 'name', 'status', null];
            
        }
        $query = self::toBase();

        //search Query
        if (!empty($this->name)) {
            $query->where('name', 'like', '%' . $this->name . '%');
        }

        if (isset($this->orderValue) && isset($this->dirValue)) {
            $query->orderBy($this->column_order[$this->orderValue], $this->dirValue);
        } else {
            $query->orderBy('id', 'desc');
        }

        return $query;
    }

    public function get_dataList()
    {
        $query = $this->get_data_table_query();

        //pagination query
        if ($this->length != -1) {
            $query->offset($this->start)->limit($this->length);
        }
        return $query->get();
    }

    public function recordsTotal()
    {
        return self::toBase()->get()->count();
    }

    public function recordsFiltered()
    {
        $query = $this->get_data_table_query();
        return  $query->get()->count();
    }
}
