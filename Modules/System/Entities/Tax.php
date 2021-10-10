<?php

namespace Modules\System\Entities;

use Modules\Base\Entities\BaseModel;




class Tax extends BaseModel
{

    protected $name;
    protected $fillable = ['name', 'rate', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];

    public function setName($name)
    {
        $this->name = $name;
    }

    protected function get_data_table_query()
    {
        if (permission('tax-bulk-delete')) {
            $this->column_order = [null, 'id', 'name', 'rate', 'status', null];
        } else {
            $this->column_order = ['id', 'name', 'rate', 'status', null];
        }
        $query = self::toBase();
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
}
