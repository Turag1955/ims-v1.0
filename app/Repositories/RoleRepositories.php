<?php

namespace App\Repositories;

use App\Models\Role;
use PharIo\Manifest\Email;

class RoleRepositories extends BaseRepositories
{
    protected $order = ['id'=>'desc'];
    protected $column;
    protected $column_order;
    protected $column_dir;
    protected $start;
    protected $length;
    protected $role_name;


    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    public function SetName($role_name)
    {
        $this->role_name = $role_name;
    }
    public function setStartValue($start)
    {
        $this->start = $start;
    }
    public function setLengthValue($length)
    {
        $this->length = $length;
    }
    public function setOrderValue($column_order)
    {
        $this->column_order = $column_order;
    }
    public function setDirValue($column_dir)
    {
        $this->column_dir = $column_dir;
    }

    protected function get_data_table_query()
    {
        $this->column = [null,'id','role_name',null,null];
        $query = $this->model->toBase();

        //search Query
        if (!empty($this->role_name)) {
            $query->where('role_name', 'like', '%' . $this->role_name . '%');
        }

        //order
        if(isset($this->column_order) && isset($this->column_dir)){
            $query->orderBy($this->column[$this->column_order],$this->column_dir);
        }else{
            $query->orderBy(key($this->order),$this->order[key($this->order)]);
        }
        return $query;
    }

    public function getDataTableList()
    {
        $query = $this->get_data_table_query();
        if($this->length != -1){
            $query->offset($this->start)->limit($this->length);
        }
        return $query->get();
    }

    public function count_all()
    {
        return $this->model->toBase()->get()->count();
    }
    

    public function count_filtered()
    {
        $query = $this->get_data_table_query();
        return $query->get()->count();
    }

    public function module_permission_data($id)
    {
        return $this->model->with('module_role','permission_role')->find($id);
    }

    public function roleList(){
        return $this->model->select('id','role_name')->get();
    }
}
