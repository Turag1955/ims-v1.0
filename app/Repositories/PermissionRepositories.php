<?php

namespace App\Repositories;

use App\Models\permission;
use App\Repositories\BaseRepositories;

class PermissionRepositories extends BaseRepositories
{
    protected $order = ['id' => 'desc'];
    protected $name;
    protected $module_id;
    protected $column_order;
    protected $column_dir;
    protected $start;
    protected $length;
    protected $column;


    public function __construct(permission $permission)
    {
        $this->model = $permission;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    public function SetModuleId($module_id)
    {
        $this->module_id = $module_id;
    }

    public function setOrderValue($column_order)
    {
        $this->column_order = $column_order;
    }
    public function setDirValue($column_dir)
    {
        $this->column_dir = $column_dir;
    }
    public function setStartValue($start)
    {
        $this->start = $start;
    }
    public function setLengthValue($length)
    {
        $this->length = $length;
    }

    protected function get_data_query()
    {
        $query = $this->model->with('module:id,module_name');

        //search Query
        if (!empty($this->name)) {
            $query->where('name', 'like',  '%' . $this->name . '%');
        }
        if (!empty($this->module_id)) {
            $query->where('module_id', $this->module_id);
        }

        //order
        $this->column = [null, 'id', 'module_id', 'name', 'slug', null];
        if (isset($this->column_order) && isset($this->column_dir)) {
            $query->orderBy($this->column[$this->column_order], $this->column_dir);
        } else {
            $query->orderBy(key($this->order), $this->order[key($this->order)]);
        }

        return $query;
    }

    public function get_data_list()
    {
        $query = $this->get_data_query();
        if ($this->length != -1) {
            $query->offset($this->start)->limit($this->length);
        }
        return $query->get();
    }

    public function count_filtered(){
        $query = $this->get_data_query();
        return $query->get()->count();
    }

    public function count_all(){
    
        return $this->model->toBase()->get()->count();
    }

    public function session_permission_list()
    {
        return $this->model->select('slug')->get();
    }
}
