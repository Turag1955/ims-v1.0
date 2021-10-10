<?php

namespace App\Repositories;

use App\Models\Menu;
use App\Repositories\BaseRepositories;

class MenuRepositories extends BaseRepositories
{

    public function __construct(Menu $model)
    {
        $this->model =  $model;
    }
    protected $order = array('id' => 'desc');

    protected  $menu_name;
    protected  $orderValue;
    protected  $dirValue;
    protected $length;
    protected $start;
    // protected $menu_name;



    protected  $column_order = [];




    public function setMenuName($menu_name)
    {
        $this->menu_name = $menu_name;
    }

    public function setOrderValue($orderValue)
    {
        $this->orderValue = $orderValue;
    }

    public function setdirValue($dirValue)
    {
        $this->dirValue = $dirValue;
    }
    public function setLengthValue($length)
    {
        $this->length = $length;
    }
    public function setStartValue($start)
    {
        $this->start = $start;
    }

    protected function get_data_table_query()
    {
        if (permission('menu-bulk-delete')) {
            $this->column_order = [null, 'id', 'menu_name', 'deletable', null];
        } else {
            $this->column_order = ['id', 'menu_name', 'deletable', null];
        }
        $query =  $this->model->toBase();

        //search Query
        if (!empty($this->menu_name)) {
            $query->where('menu_name', 'like', '%' . $this->menu_name . '%');
        }

        //order query
        if (isset($this->orderValue) && isset($this->dirValue)) {
            $query->orderBy($this->column_order[$this->orderValue], $this->dirValue);
        } elseif (isset($this->order)) {
            $query->orderBy(key($this->order), $this->order[key($this->order)]);
        }

        return $query;
    }

    public function getDataTableList()
    {
        $query = $this->get_data_table_query();

        //pagination query
        if ($this->length != -1) {
            $query->offset($this->start)->limit($this->length);
        }
        return $query->get();
    }

    public function count_filtered()
    {
        $query = $this->get_data_table_query();
        return $query->get()->count();
    }
    public function count_all()
    {
        return $this->model->toBase()->get()->count();
    }

    public function withMenuItem($id)
    {
        return  $this->model->with('menuItem')->findOrFail($id);
    }
}
